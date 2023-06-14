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
        Schema::create('item_licitacao', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');
            $table->bigInteger('licitacao_id')->unsigned();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes')->onDelete('cascade');
            $table->smallInteger('ordem');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('item_licitacao');
    }
};
