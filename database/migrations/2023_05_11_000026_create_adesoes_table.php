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
        Schema::create('adesoes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Menor preço', 'Meior desconto']);
            $table->enum('forma', ['Presencial', 'Eletrônico']);
            $table->string('origem_processo', 20);
            $table->bigInteger('origem_uasg_id')->unsigned();
            $table->foreign('origem_uasg_id')->references('id')->on('uasgs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adesoes');
    }
};
