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
        Schema::create('cotacoes', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('fonte', 150);
            $table->double('valor', 10, 4);
            $table->datetime('data')->nullable();
            $table->enum('parametro', [1, 2, 3, 4, 5]);
            $table->boolean('is_valida')->default(1);
            $table->bigInteger('item_id')->unsigned();
            $table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cotacoes');
    }
};
