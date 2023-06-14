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
        Schema::create('dispensas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->tinyInteger('enquadramento');
            $table->text('justificativa');
            $table->boolean('has_disputa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dispensas');
    }
};
