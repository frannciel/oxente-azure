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
        Schema::create('emails', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->string('e-mail', 50)->nullable()->unique();
            $table->boolean('prioridade')->default(0);
            $table->bigInteger('emailable_id')->unsigned();
            $table->string('emailable_type', 40);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('emails');
    }
};
