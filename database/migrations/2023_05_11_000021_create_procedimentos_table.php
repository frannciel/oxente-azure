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
        Schema::create('procedimentos', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->smallInteger('numero');
            $table->smallInteger('ano');
            $table->string('objeto', 300);
            $table->string('processo', 20);
            $table->date('data_publicacao')->nullable();
            $table->bigInteger('procedimentoable_id')->unsigned();
            $table->string('procedimentoable_type', 40);
            $table->bigInteger('uasg_id')->unsigned();
            $table->foreign('uasg_id')->references('id')->on('uasgs')->onDelete('cascade');
            $table->unique(['numero', 'ano']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('procedimentos');
    }
};
