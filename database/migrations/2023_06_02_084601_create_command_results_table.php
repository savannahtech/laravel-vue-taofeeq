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
        Schema::create('command_results', function (Blueprint $table) {
            $table->id();
            $table->string('data');
            $table->bigInteger('command_id')->unsigned()->nullable();
            $table->foreign('command_id')->references('id')->on('commands')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('command_results');
    }
};
