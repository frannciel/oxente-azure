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
        Schema::create('item_registro_de_precos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('registro_precos_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');
            $table->foreign('registro_precos_id')->references('id')->on('registros_de_precos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_registro_de_precos');
    }
};
