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
        Schema::create('answer', function (Blueprint $table) {
            $table->id();
            $table->integer('user')->unsigned();
            $table->integer('quiz')->unsigned();
            $table->integer('answer_type')->unsigned();
            $table->string('answer', 500);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer');
    }
};
