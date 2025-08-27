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
       Schema::create('cajas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('movimiento_id')->nullable()->constrained()->onDelete('cascade');

        $table->string('buyer')->nullable();
        $table->date('shipping_date')->nullable();
        $table->string('purchase_order')->nullable();
        $table->text('shipped_from')->nullable();
        $table->text('sold_to')->nullable();
        $table->text('shipped_to')->nullable();

        $table->foreignId('cliente_id')->nullable()->constrained('clientes')->onDelete('set null');
        $table->foreignId('almacen_id')->nullable()->constrained('almacenes')->onDelete('set null');

        $table->integer('numero')->default(1);
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cajas');
    }
};
