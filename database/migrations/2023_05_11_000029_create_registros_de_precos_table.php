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
        Schema::create('registros_de_precos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->smallInteger('numero');
            $table->smallInteger('ano');
            $table->date('assinatura');
            $table->date('vigencia_inicio');
            $table->date('vigencia_fim');
            $table->boolean('has_adesao');
            $table->bigInteger('fornecedor_id')->unsigned();
            $table->bigInteger('licitacao_id')->unsigned();
            $table->foreign('licitacao_id')->references('id')->on('licitacoes')->onDelete('cascade');
            $table->foreign('fornecedor_id')->references('id')->on('fornecedores')->onDelete('cascade');
            $table->unique(['numero', 'ano']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_de_precos');
    }
};
