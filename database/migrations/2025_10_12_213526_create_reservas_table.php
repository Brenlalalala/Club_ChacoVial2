<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id(); // id_reserva
            $table->unsignedBigInteger('instalacion_id');
            $table->string('nombre_cliente', 100);
            $table->string('email_cliente', 150);
            $table->string('telefono_cliente', 20);
            $table->date('fecha_reserva'); // fecha de la reserva
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->enum('estado', ['pendiente', 'aceptada', 'cancelada'])->default('pendiente');
            $table->decimal('precio_total', 10, 2);
            $table->text('comentarios')->nullable(); // para notas del cliente o admin
            $table->timestamps();

            // Foreign key
            $table->foreign('instalacion_id')
                  ->references('id')
                  ->on('instalaciones')
                  ->onDelete('cascade');
            
            // Índices para búsquedas rápidas
            $table->index('estado');
            $table->index('fecha_reserva');
            $table->index(['instalacion_id', 'fecha_inicio', 'fecha_fin']); // para verificar disponibilidad
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservas');
    }
};