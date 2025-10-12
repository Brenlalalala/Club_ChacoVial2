<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instalaciones', function (Blueprint $table) {
            $table->id(); // id_instalacion
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->integer('capacidad');
            $table->decimal('precio_hora', 10, 2);
            $table->string('imagen_url')->nullable();
            $table->unsignedBigInteger('seccion_id')->nullable();
            $table->boolean('activa')->default(true); // para desactivar sin eliminar
            $table->timestamps();

            // Si ya existe la tabla secciones:
            // $table->foreign('seccion_id')->references('id')->on('secciones')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instalaciones');
    }
};