<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('almacenes', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('identificador')->nullable();           
            $table->string('calle')->nullable();  
            $table->string('numero')->nullable(); 
            $table->string('colonia')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('estado')->nullable();
            $table->string('pais')->nullable();
            $table->string('cp')->nullable();       
            $table->string('telefono')->nullable();
            $table->string('web')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('almacenes');
    }
};
