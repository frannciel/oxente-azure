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
        Schema::create('requisicoes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->mediumInteger('numero');
            $table->smallInteger('ano');
            $table->string('descricao', 200);
            $table->text('justificativa');
            $table->enum('classificacao',['Material', 'Serviço', 'Obra']);
            $table->enum('prioridade', ['Baixa', 'Média', 'Alta']);
            $table->boolean('capacitacao');
            $table->smallInteger('dfd_ano')->nullable();
            $table->smallInteger('dfd_numero')->nullable();
            $table->date('previsao')->nullable();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('unidade_administrativas_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('unidade_administrativas_id')->references('id')->on('unidades_administrativas');
            $table->unique(['numero', 'ano']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requisicoes');
    }
};
