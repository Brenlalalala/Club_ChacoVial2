<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\NuevaReservaSolicitud;

class ReservaController extends Controller
{
    // Mostrar formulario de reserva
    public function create($instalacionId)
    {
        $instalacion = Instalacion::activas()->findOrFail($instalacionId);
        return view('reservas.create', compact('instalacion'));
    }

    // Procesar la reserva
    public function store(Request $request)
    {
        $validated = $request->validate([
            'instalacion_id' => 'required|exists:instalaciones,id',
            'nombre_cliente' => 'required|string|max:100',
            'email_cliente' => 'required|email|max:150',
            'telefono_cliente' => 'required|string|max:20',
            'fecha_inicio' => 'required|date|after:now',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'comentarios' => 'nullable|string|max:500'
        ]);

        $instalacion = Instalacion::findOrFail($validated['instalacion_id']);

        // Verificar disponibilidad
        if (!$instalacion->estaDisponible($validated['fecha_inicio'], $validated['fecha_fin'])) {
            return back()->withErrors(['fecha_inicio' => 'La instalación no está disponible en ese horario.'])
                        ->withInput();
        }

        // Crear la reserva
        $reserva = new Reserva($validated);
        $reserva->fecha_reserva = now()->toDateString();
        $reserva->estado = 'pendiente';
        $reserva->calcularPrecio();
        $reserva->save();

        // Notificar al admin (puedes configurar el email del admin en .env)
        Mail::to(config('mail.admin_email'))->send(new NuevaReservaSolicitud($reserva));

        return redirect()->route('reservas.confirmacion', $reserva->id)
                        ->with('success', 'Reserva solicitada correctamente. Recibirá un email de confirmación.');
    }

    // Página de confirmación
    public function confirmacion($id)
    {
        $reserva = Reserva::with('instalacion')->findOrFail($id);
        return view('reservas.confirmacion', compact('reserva'));
    }

    // API para verificar disponibilidad (para AJAX)
    public function verificarDisponibilidad(Request $request)
    {
        $validated = $request->validate([
            'instalacion_id' => 'required|exists:instalaciones,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ]);

        $instalacion = Instalacion::find($validated['instalacion_id']);
        $disponible = $instalacion->estaDisponible($validated['fecha_inicio'], $validated['fecha_fin']);

        return response()->json([
            'disponible' => $disponible,
            'mensaje' => $disponible ? 'Horario disponible' : 'Horario no disponible'
        ]);
    }
}