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
        Schema::create('pregoes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Menor preço', 'Meior desconto']);
            $table->enum('forma', ['Presencial', 'Eletrônico']);
            $table->boolean('is_srp');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pregoes');
    }
};
