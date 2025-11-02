<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserva;
use Illuminate\Http\Request;
use App\Exports\ReservasExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class ReservaAdminController extends Controller
{
    // Listar todas las reservas
   public function index(Request $request)
{
    $query = Reserva::with('instalacion')->latest();

    // Filtrar por estado
    if ($request->has('estado') && $request->estado != '') {
        $query->where('estado', $request->estado);
    }

    // Filtrar por fecha
    if ($request->has('fecha') && $request->fecha != '') {
        $query->whereDate('fecha_reserva', $request->fecha);
    }

    // Filtrar por instalación
    if ($request->has('instalacion') && $request->instalacion != '') {
        $query->where('instalacion_id', $request->instalacion);
    }

    $reservas = $query->paginate(15)->appends($request->all());

    return view('admin.reservas.index', compact('reservas'));
}

    // Ver detalle de una reserva
    public function show($id)
    {
        $reserva = Reserva::with('instalacion')->findOrFail($id);
        return view('admin.reservas.show', compact('reserva'));
    }

    // Confirmar reserva
    public function confirmar($id)
    {
        $reserva = Reserva::findOrFail($id);
        
        if ($reserva->estado !== 'pendiente') {
            return back()->withErrors(['error' => 'Solo se pueden confirmar reservas pendientes.']);
        }

        $reserva->confirmar();

        return redirect()->route('admin.reservas.show', $reserva->id)
                        ->with('success', 'Reserva confirmada exitosamente. Email enviado al cliente.');
    }

    // Cancelar reserva
    public function cancelar(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

        $request->validate([
            'motivo' => 'nullable|string|max:500'
        ]);

        $reserva->cancelar($request->motivo);

        return redirect()->route('admin.reservas.show', $reserva->id)
                        ->with('success', 'Reserva cancelada. Email enviado al cliente.');
    }

    // Editar reserva (cambiar fechas, precio, etc.)
    public function edit($id)
    {
        $reserva = Reserva::with('instalacion')->findOrFail($id);
        return view('admin.reservas.edit', compact('reserva'));
    }

    // Actualizar reserva
    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);

       
    if ($request->has('fecha') && $request->has('hora_inicio') && $request->has('hora_fin')) {
        $request->merge([
            'fecha_inicio' => $request->fecha . ' ' . $request->hora_inicio . ':00',
            'fecha_fin' => $request->fecha . ' ' . $request->hora_fin . ':00',
        ]);
    }

        $validated = $request->validate([
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'precio_total' => 'required|numeric|min:0',
            'comentarios' => 'nullable|string|max:1000'
        ]);

        $reserva->update($validated);

        return redirect()->route('admin.reservas.show', $reserva->id)
                        ->with('success', 'Reserva actualizada correctamente.');
    }


    //Exportar a Excel
    public function exportExcel(Request $request)
    {
        $filters = [
            'estado' => $request->get('estado'),
            'fecha' => $request->get('fecha'),
            'instalacion' => $request->get('instalacion'),
        ];

        $filename = 'reservas_' . date('Y-m-d_His') . '.xlsx';
        
        return Excel::download(new ReservasExport($filters), $filename);
    }

    //Exportar a PDF
    public function exportPdf(Request $request)
    {
        $query = Reserva::with('instalacion')->latest();

        $filtros = [];

        // Aplicar filtros
        if ($request->has('estado') && $request->estado != '') {
            $query->where('estado', $request->estado);
            $filtros['estado'] = $request->estado;
        }

        if ($request->has('fecha') && $request->fecha != '') {
            $query->whereDate('fecha_reserva', $request->fecha);
            $filtros['fecha'] = $request->fecha;
        }

        if ($request->has('instalacion') && $request->instalacion != '') {
            $query->where('instalacion_id', $request->instalacion);
            $filtros['instalacion'] = $request->instalacion;
        }

        $reservas = $query->get();

        $pdf = Pdf::loadView('admin.reservas.pdf', [
            'reservas' => $reservas,
            'filtros' => $filtros
        ]);

        $pdf->setPaper('a4', 'landscape'); // Horizontal para más columnas

        $filename = 'reservas_' . date('Y-m-d_His') . '.pdf';

        return $pdf->download($filename);
    }

    // Exportar una sola reserva a PDF (comprobante)
    public function exportComprobante($id)
    {
        $reserva = Reserva::with('instalacion')->findOrFail($id);

        $pdf = Pdf::loadView('admin.reservas.comprobante-pdf', [
            'reserva' => $reserva
        ]);

        $pdf->setPaper('a4', 'portrait');

        $filename = 'comprobante_reserva_' . str_pad($reserva->id, 6, '0', STR_PAD_LEFT) . '.pdf';

        return $pdf->download($filename);
    }
}