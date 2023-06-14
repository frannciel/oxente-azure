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
        Schema::create('fornecedores', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('endereco', 300)->nullable();
            $table->string('cep', 10)->nullable();
            $table->bigInteger('fornecedorable_id')->unsigned();
            $table->string('fornecedorable_type', 40);
            $table->bigInteger('cidade_id')->nullable()->unsigned();
            $table->foreign('cidade_id')->references('id')->on('cidades');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fornecedores');
    }
};
