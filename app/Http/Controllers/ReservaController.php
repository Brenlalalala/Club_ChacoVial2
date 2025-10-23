<?php

namespace App\Http\Controllers;

use App\Models\Instalacion;
use App\Models\Reserva;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ReservaController extends Controller
{
    // Muestra el formulario para crear una nueva reserva.
     
    public function create($instalacionId = null)
    {
        if ($instalacionId) {
            // Caso 1: se selecciona una instalación específica desde un botón.
            $instalacion = Instalacion::where('activa', true)->findOrFail($instalacionId);
            return view('reservas.create', compact('instalacion'));
        } else {
            // Caso 2: se accede a la página general de reservas para elegir una.
            $instalaciones = Instalacion::where('activa', true)->get();
            
            if ($instalaciones->isEmpty()) {
                // Redirige si no hay instalaciones disponibles.
                return redirect()->back()->with('error', 'No hay instalaciones disponibles en este momento.');
            }
            
            return view('reservas.create', compact('instalaciones'));
        }
    }

    //Almacena una nueva solicitud de reserva en la base de datos.
     
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
        ], [
            'instalacion_id.required' => 'Debe seleccionar una instalación.',
            'nombre_cliente.required' => 'El nombre es obligatorio.',
            'email_cliente.required' => 'El email es obligatorio.',
            'fecha_inicio.required' => 'Debe seleccionar fecha y hora de inicio.',
            'fecha_fin.after' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ]);

        $instalacion = Instalacion::findOrFail($validated['instalacion_id']);

        // Verificar disponibilidad
        if (!$instalacion->estaDisponible($validated['fecha_inicio'], $validated['fecha_fin'])) {
            return back()
                ->withErrors(['fecha_inicio' => 'La instalación no está disponible en ese horario. Por favor, elige otro horario.'])
                ->withInput();
        }

        // Crear la reserva
        $reserva = new Reserva($validated);
        $reserva->fecha_reserva = now()->toDateString();
        $reserva->estado = 'pendiente';
        $reserva->calcularPrecio();
        $reserva->save();

        // Notificar al admin (configura ADMIN_EMAIL en el .env)
        try {
            if (config('mail.admin_email')) {
                // Mail::to(config('mail.admin_email'))->send(new NuevaReservaSolicitud($reserva));
            }
        } catch (\Exception $e) {
            // Log del error pero no interrumpir el flujo
            \Log::error('Error al enviar email de nueva reserva: ' . $e->getMessage());
        }

        return redirect()
            ->route('reservas.confirmacion', $reserva->id)
            ->with('success', '¡Reserva solicitada correctamente! Recibirás un email cuando sea confirmada.');
    }

    // Página de confirmación
    public function confirmacion($id)
    {
        $reserva = Reserva::with('instalacion')->findOrFail($id);
        return view('reservas.confirmacion', compact('reserva'));
    }

    // API para verificar disponibilidad (AJAX)
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
            'mensaje' => $disponible 
                ? 'Horario disponible ✓' 
                : 'Este horario ya está reservado. Por favor, elige otro horario.'
        ]);
    }
}
