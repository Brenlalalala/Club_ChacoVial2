<?php

namespace App\Exports;

use App\Models\Reserva;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReservasExport implements FromCollection, WithHeadings
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function collection()
    {
        $query = Reserva::with('instalacion')->latest();

        // Aplicar filtros
        if (isset($this->filters['estado']) && $this->filters['estado'] != '') {
            $query->where('estado', $this->filters['estado']);
        }

        if (isset($this->filters['fecha']) && $this->filters['fecha'] != '') {
            $query->whereDate('fecha_reserva', $this->filters['fecha']);
        }

        if (isset($this->filters['instalacion']) && $this->filters['instalacion'] != '') {
            $query->where('instalacion_id', $this->filters['instalacion']);
        }

        return $query->get()->map(function($reserva) {
            return [
                'ID' => $reserva->id,
                'Cliente' => $reserva->nombre_cliente,
                'Email' => $reserva->email_cliente,
                'Teléfono' => $reserva->telefono_cliente,
                'Instalación' => $reserva->instalacion->nombre,
                'Fecha' => $reserva->fecha_inicio->format('d/m/Y'),
                'Hora Inicio' => $reserva->fecha_inicio->format('H:i'),
                'Hora Fin' => $reserva->fecha_fin->format('H:i'),
                'Duración' => $reserva->horas_reserva . 'h',
                'Precio' => '$' . number_format($reserva->precio_total, 2),
                'Estado' => strtoupper($reserva->estado),
                'Comentarios' => $reserva->comentarios ?? 'N/A',
                'Fecha Solicitud' => $reserva->created_at->format('d/m/Y H:i'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Cliente',
            'Email',
            'Teléfono',
            'Instalación',
            'Fecha Reserva',
            'Hora Inicio',
            'Hora Fin',
            'Duración',
            'Precio Total',
            'Estado',
            'Comentarios',
            'Fecha Solicitud',
        ];
    }
}