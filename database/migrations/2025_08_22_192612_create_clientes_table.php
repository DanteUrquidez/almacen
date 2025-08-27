<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('identificador')->nullable();
            $table->string('calle')->nullable(); 
            $table->string('numero')->nullable(); 
            $table->string('colonia')->nullable();
            $table->string('ciudad')->nullable();  
            $table->string('municipio')->nullable(); 
            $table->string('estado')->nullable(); 
            $table->string('pais')->nullable(); 
            $table->string('cp', 10)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
