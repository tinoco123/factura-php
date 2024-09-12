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
        Schema::create('conceptos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_producto');
            $table->enum('tipo', ['producto','servicio'])->default('producto');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 6, 2);
            $table->foreignId("iva_id")->constrained();
            $table->foreignId("factura_id")->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('conceptos');
    }
};
