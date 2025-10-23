<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instalacion;
use Illuminate\Http\Request;

class InstalacionController extends Controller
{
    // Listar todas las instalaciones
    public function index()
    {
        $instalaciones = Instalacion::withCount('reservas')->paginate(10);
        return view('admin.instalaciones.index', compact('instalaciones'));
    }

    // Mostrar formulario de crear
    public function create()
    {
        return view('admin.instalaciones.create');
    }

    // Guardar nueva instalación
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'capacidad' => 'required|integer|min:1',
            'precio_hora' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|string|max:255',
            'activa' => 'boolean'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'capacidad.min' => 'La capacidad debe ser al menos 1 persona.',
            'precio_hora.required' => 'El precio por hora es obligatorio.',
            'precio_hora.min' => 'El precio debe ser mayor o igual a 0.',
        ]);

        // Por defecto activa = true si no se envía
        $validated['activa'] = $request->has('activa') ? true : false;

        Instalacion::create($validated);

        return redirect()->route('admin.instalaciones.index')
                        ->with('success', 'Instalación creada correctamente.');
    }

    // Ver detalle de una instalación
    public function show($id)
    {
        $instalacion = Instalacion::withCount('reservas')->findOrFail($id);
        $reservasRecientes = $instalacion->reservas()
                                        ->with('instalacion')
                                        ->latest()
                                        ->take(10)
                                        ->get();
        
        return view('admin.instalaciones.show', compact('instalacion', 'reservasRecientes'));
    }

    // Mostrar formulario de editar
    public function edit($id)
    {
        $instalacion = Instalacion::findOrFail($id);
        return view('admin.instalaciones.edit', compact('instalacion'));
    }

    // Actualizar instalación
    public function update(Request $request, $id)
    {
        $instalacion = Instalacion::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'capacidad' => 'required|integer|min:1',
            'precio_hora' => 'required|numeric|min:0',
            'imagen_url' => 'nullable|string|max:255',
            'activa' => 'boolean'
        ]);

        $validated['activa'] = $request->has('activa') ? true : false;

        $instalacion->update($validated);

        return redirect()->route('admin.instalaciones.show', $instalacion->id)
                        ->with('success', 'Instalación actualizada correctamente.');
    }

    // Eliminar instalación
    public function destroy($id)
    {
        $instalacion = Instalacion::findOrFail($id);
        
        // Verificar si tiene reservas
        $reservasCount = $instalacion->reservas()->count();
        
        if ($reservasCount > 0) {
            return back()->withErrors(['error' => "No se puede eliminar esta instalación porque tiene {$reservasCount} reserva(s) asociada(s). Desactívala en su lugar."]);
        }

        $instalacion->delete();

        return redirect()->route('admin.instalaciones.index')
                        ->with('success', 'Instalación eliminada correctamente.');
    }

    // Toggle activar/desactivar
    public function toggleActiva($id)
    {
        $instalacion = Instalacion::findOrFail($id);
        $instalacion->activa = !$instalacion->activa;
        $instalacion->save();

        $estado = $instalacion->activa ? 'activada' : 'desactivada';
        
        return back()->with('success', "Instalación {$estado} correctamente.");
    }
}