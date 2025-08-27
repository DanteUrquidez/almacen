<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('parte_id');
        $table->unsignedBigInteger('cliente_id')->nullable();
        $table->unsignedBigInteger('almacen_id')->nullable();
        $table->enum('tipo', ['entrada', 'salida']);
        $table->integer('cantidad');
        $table->text('descripcion')->nullable();
        $table->timestamps();
        $table->foreign('parte_id')->references('id')->on('partes')->onDelete('cascade');
        $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('set null');
        $table->foreign('almacen_id')->references('id')->on('almacenes')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entradas');
    }
};
