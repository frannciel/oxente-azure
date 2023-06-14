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
        Schema::create('cotacao_justificativas', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['validade', 'escolha']);
            $table->text('justificativa');
            $table->bigInteger('cotacao_id')->unsigned();
            $table->foreign('cotacao_id')->references('id')->on('cotacoes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotacao_justificativas');
    }
};
