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
        Schema::create('unidades_administrativas', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('nome', 150);
            $table->string('sigla', 30);
            $table->bigInteger('uasg_id')->unsigned();
            $table->foreign('uasg_id')->references('id')->on('uasgs')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unidades_administrativas');
    }
};
