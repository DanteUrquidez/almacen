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
        Schema::create('items', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('caja_id');
        $table->unsignedBigInteger('parte_id');
        $table->string('item_no')->nullable();
        $table->string('pkg_size')->nullable();
        $table->string('pkg_weight')->nullable();
        $table->timestamps();

        $table->foreign('caja_id')->references('id')->on('cajas')->onDelete('cascade');
        $table->foreign('parte_id')->references('id')->on('partes')->onDelete('restrict');
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
