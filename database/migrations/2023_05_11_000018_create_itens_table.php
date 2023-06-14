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
        Schema::create('itens', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->smallInteger('numero');
            $table->integer('quantidade');
            $table->integer('codigo')->nullable();
            $table->string('objeto', 300)->nullable();
            $table->text('descricao');
            $table->bigInteger('grupo_id')->unsigned()->nullable();
            $table->bigInteger('requisicao_id')->unsigned()->nullable();
            $table->bigInteger('unidade_id')->unsigned()->nullable();
            $table->foreign('unidade_id')->references('id')->on('unidades')->onDelete('set null');
            $table->foreign('requisicao_id')->references('id')->on('requisicoes')->onDelete('cascade');
            $table->foreign('grupo_id')->references('id')->on('grupos')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('itens');
    }
};
