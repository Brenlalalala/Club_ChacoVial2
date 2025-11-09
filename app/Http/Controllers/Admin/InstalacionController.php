<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instalacion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class InstalacionController extends Controller
{
    public function index()
    {
        $instalaciones = Instalacion::withCount('reservas')->paginate(10);
        return view('admin.instalaciones.index', compact('instalaciones'));
    }

    public function create()
    {
        return view('admin.instalaciones.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'capacidad' => 'required|integer|min:1',
            'precio_hora' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activa' => 'boolean'
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'capacidad.required' => 'La capacidad es obligatoria.',
            'precio_hora.required' => 'El precio por hora es obligatorio.',
            'imagen.image' => 'El archivo debe ser una imagen.',
            'imagen.mimes' => 'Solo se permiten imágenes JPG, PNG o GIF.',
            'imagen.max' => 'La imagen no debe superar los 2MB.',
        ]);

        $validated['activa'] = $request->has('activa') ? true : false;

        // Manejar subida de imagen
        if ($request->hasFile('imagen')) {
            // Crear directorio si no existe
            $directorio = public_path('images/instalaciones');
            if (!File::exists($directorio)) {
                File::makeDirectory($directorio, 0755, true);
            }
            
            // Generar nombre único
            $nombreArchivo = time() . '_' . str_replace(' ', '_', $request->file('imagen')->getClientOriginalName());
            
            // Mover archivo
            $request->file('imagen')->move($directorio, $nombreArchivo);
            
            // Guardar ruta relativa
            $validated['imagen_url'] = 'images/instalaciones/' . $nombreArchivo;
        }

        Instalacion::create($validated);

        return redirect()->route('admin.instalaciones.index')
                        ->with('success', 'Instalación creada correctamente.');
    }

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

    public function edit($id)
    {
        $instalacion = Instalacion::findOrFail($id);
        return view('admin.instalaciones.edit', compact('instalacion'));
    }

    public function update(Request $request, $id)
    {
        $instalacion = Instalacion::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'capacidad' => 'required|integer|min:1',
            'precio_hora' => 'required|numeric|min:0',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'activa' => 'boolean'
        ]);

        $validated['activa'] = $request->has('activa') ? true : false;

        // Manejar nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar imagen anterior si existe
            if ($instalacion->imagen_url && File::exists(public_path($instalacion->imagen_url))) {
                File::delete(public_path($instalacion->imagen_url));
            }
            
            // Crear directorio si no existe
            $directorio = public_path('images/instalaciones');
            if (!File::exists($directorio)) {
                File::makeDirectory($directorio, 0755, true);
            }
            
            // Generar nombre único
            $nombreArchivo = time() . '_' . str_replace(' ', '_', $request->file('imagen')->getClientOriginalName());
            
            // Mover archivo
            $request->file('imagen')->move($directorio, $nombreArchivo);
            
            // Guardar ruta relativa
            $validated['imagen_url'] = 'images/instalaciones/' . $nombreArchivo;
        }

        $instalacion->update($validated);

        return redirect()->route('admin.instalaciones.show', $instalacion->id)
                        ->with('success', 'Instalación actualizada correctamente.');
    }

    public function destroy($id)
    {
        $instalacion = Instalacion::findOrFail($id);
        
        $reservasCount = $instalacion->reservas()->count();
        
        if ($reservasCount > 0) {
            return back()->withErrors(['error' => "No se puede eliminar esta instalación porque tiene {$reservasCount} reserva(s) asociada(s)."]);
        }

        // Eliminar imagen si existe
        if ($instalacion->imagen_url && File::exists(public_path($instalacion->imagen_url))) {
            File::delete(public_path($instalacion->imagen_url));
        }

        $instalacion->delete();

        return redirect()->route('admin.instalaciones.index')
                        ->with('success', 'Instalación eliminada correctamente.');
    }

    public function toggleActiva($id)
    {
        $instalacion = Instalacion::findOrFail($id);
        $instalacion->activa = !$instalacion->activa;
        $instalacion->save();

        $estado = $instalacion->activa ? 'activada' : 'desactivada';
        
        return back()->with('success', "Instalación {$estado} correctamente.");
    }

    public function eliminarImagen($id)
    {
        $instalacion = Instalacion::findOrFail($id);

        if ($instalacion->imagen_url && File::exists(public_path($instalacion->imagen_url))) {
            File::delete(public_path($instalacion->imagen_url));
            $instalacion->imagen_url = null;
            $instalacion->save();
            
            return back()->with('success', 'Imagen eliminada correctamente.');
        }

        return back()->withErrors(['error' => 'No hay imagen para eliminar.']);
    }
}