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
        Schema::create('cidade_item_uasg', function (Blueprint $table) {
			$table->bigInteger('cidade_id')->unsigned();
            $table->bigInteger('uasg_id')->unsigned();
			$table->bigInteger('item_id')->unsigned();
            $table->foreign('cidade_id')->references('id')->on('cidades')->onDelete('cascade');
			$table->foreign('item_id')->references('id')->on('itens')->onDelete('cascade');
            $table->foreign('uasg_id')->references('id')->on('uasgs')->onDelete('cascade');
            $table->integer('quantidade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cidade_item_uasg');
    }
};
