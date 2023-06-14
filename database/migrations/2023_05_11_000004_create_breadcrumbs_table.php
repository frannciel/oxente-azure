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
        Schema::create('breadcrumbs', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('title');
            $table->boolean('has_parameters')->default(0);
            $table->bigInteger('breadcrumb_id')->unsigned()->nullable();
            $table->foreign('breadcrumb_id')->references('id')->on('breadcrumbs')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('breadcrumbs');
    }
};