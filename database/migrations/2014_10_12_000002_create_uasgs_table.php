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
        Schema::create('uasgs', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nome', 120);
            $table->integer('codigo')->unique();
            $table->bigInteger('cidade_id')->nullable()->unsigned();
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('uasgs');
    }
};
