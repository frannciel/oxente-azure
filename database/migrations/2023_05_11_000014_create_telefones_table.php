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
        Schema::create('telefones', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('numero', 20)->unique()->nullable();
            $table->integer('ramal')->nullable();
            $table->tinyInteger('tipo')->nullable();
            $table->boolean('prioridade')->default(0);
            $table->bigInteger('telefoneable_id')->unsigned();
            $table->string('telefoneable_type', 40);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telefones');
    }
};
