<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instalacion extends Model
{
    use HasFactory;

    protected $table = 'instalaciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'capacidad',
        'precio_hora',
        'imagen_url',
        'seccion_id',
        'activa'
    ];

    protected $casts = [
        'precio_hora' => 'decimal:2',
        'capacidad' => 'integer',
        'activa' => 'boolean',
    ];

    // Relación con reservas
    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'instalacion_id');
    }

    // Scope para instalaciones activas
    public function scopeActivas($query)
    {
        return $query->where('activa', true);
    }

    // Verificar disponibilidad en un rango de fechas
    public function estaDisponible($fechaInicio, $fechaFin)
    {
        return !$this->reservas()
            ->where('estado', '!=', 'cancelada')
            ->where(function ($query) use ($fechaInicio, $fechaFin) {
                $query->whereBetween('fecha_inicio', [$fechaInicio, $fechaFin])
                      ->orWhereBetween('fecha_fin', [$fechaInicio, $fechaFin])
                      ->orWhere(function ($q) use ($fechaInicio, $fechaFin) {
                          $q->where('fecha_inicio', '<=', $fechaInicio)
                            ->where('fecha_fin', '>=', $fechaFin);
                      });
            })
            ->exists();
    }
}