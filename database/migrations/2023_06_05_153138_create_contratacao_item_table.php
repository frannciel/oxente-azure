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
        Schema::create('contratacao_item', function (Blueprint $table) {
            $table->id();
            $table->integer('quantidade');
            $table->double('valor', 12, 4);
            $table->bigInteger('item_id')->unsigned();
            $table->bigInteger('contratacao_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');
            $table->foreign('contratacao_id')->references('id')->on('contratacoes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contratacao_item');
    }
};
