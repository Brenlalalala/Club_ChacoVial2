<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaConfirmada;
use App\Mail\ReservaCancelada;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'instalacion_id',
        'nombre_cliente',
        'email_cliente',
        'telefono_cliente',
        'fecha_reserva',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'precio_total',
        'comentarios'
    ];

    protected $casts = [
        'fecha_reserva' => 'date',
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'precio_total' => 'decimal:2',
    ];

    // Relación con instalación
    public function instalacion()
    {
        return $this->belongsTo(Instalacion::class, 'instalacion_id');
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeAceptadas($query)
    {
        return $query->where('estado', 'aceptada');
    }

    public function scopeCanceladas($query)
    {
        return $query->where('estado', 'cancelada');
    }

    // Calcular horas de reserva
    public function getHorasReservaAttribute()
    {
        $inicio = $this->fecha_inicio;
        $fin = $this->fecha_fin;
        return $inicio->diffInHours($fin);
    }

    // Calcular precio automáticamente
    public function calcularPrecio()
    {
        $horas = $this->horas_reserva;
        $precioHora = $this->instalacion->precio_hora;
        $this->precio_total = $horas * $precioHora;
        return $this->precio_total;
    }

    // Confirmar reserva
    public function confirmar()
    {
        $this->estado = 'aceptada';
        $this->save();
        
        // Enviar email de confirmación
        Mail::to($this->email_cliente)->send(new ReservaConfirmada($this));
        
        return $this;
    }

    // Cancelar reserva
    public function cancelar($motivo = null)
    {
        $this->estado = 'cancelada';
        if ($motivo) {
            $this->comentarios = ($this->comentarios ? $this->comentarios . "\n" : '') . "Motivo cancelación: " . $motivo;
        }
        $this->save();
        
        // Enviar email de cancelación
        Mail::to($this->email_cliente)->send(new ReservaCancelada($this));
        
        return $this;
    }
}