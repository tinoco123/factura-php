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
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();
            $table->string('folio')->unique();
            $table->string('moneda');
            $table->string("tipo_cambio");
            $table->text("comentario");
            $table->foreignId("pago_id")->nullable()->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger("emisor_id");
            $table->foreign("emisor_id")->references("id")->on("agentes")->cascadeOnDelete();
            $table->unsignedBigInteger(column: "receptor_id");
            $table->foreign("receptor_id")->references("id")->on("agentes")->cascadeOnDelete();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facturas');
    }
};
