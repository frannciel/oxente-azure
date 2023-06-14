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
        Schema::create('fornecedor_item', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade')->nullable();
            $table->double('valor', 12, 4)->nullable(); // número max 99.999.999,9999
            $table->string('marca', 50)->nullable();
            $table->string('modelo', 50)->nullable();
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('fornecedor_id')->unsigned();
            $table->bigInteger('licitacao_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('cascade');
            $table->foreign('licitacao_id')->references('id')->on('licitacoes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedor_item');
    }
};
