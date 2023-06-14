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
        Schema::create('contratacoes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('contrato')->nullable();
            $table->string('observacao')->nullable();
            $table->bigInteger('fornecedor_id')->unsigned();
            $table->bigInteger('licitacao_id')->unsigned();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('cascade');
            $table->foreign('licitacao_id')->references('id')->on('licitacoes')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratacoes');
    }
};
