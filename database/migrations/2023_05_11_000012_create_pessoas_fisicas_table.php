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
        Schema::create('pessoas_fisicas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nome', 60);
            $table->string('cpf', 14)->unique();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pessoas_fisicas');
    }
};
