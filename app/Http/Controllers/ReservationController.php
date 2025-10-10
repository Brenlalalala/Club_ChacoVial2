<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Guarda una nueva reserva en la base de datos.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // 1. Validar los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'instalacion' => 'required|string|max:255',
            'fecha' => 'required|date',
            'hora' => 'required|date_format:H:i',
            'comentarios' => 'nullable|string',
        ]);

        // 2. Acá va la lógica para guardar la reserva en la base de datos
        // Por ejemplo, si queremos tener un modelo de Reserva:
        // Reserva::create($validatedData);

        // 3. Redirigir al usuario con un mensaje de éxito
        return redirect()->back()->with('success', '¡Tu reserva ha sido confirmada con éxito!');
    }
}