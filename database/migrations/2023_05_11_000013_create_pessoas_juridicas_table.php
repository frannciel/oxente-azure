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
        Schema::create('pessoas_juridicas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('cnpj', 18)->unique();
            $table->string('razao_social', 200);
            $table->string('nome_representante', 60)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas_juridicas');
    }
};
