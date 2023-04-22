<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('post', function (Blueprint $table) {
            $table->id();
            $table->string('description', 500);
            $table->string('content_url', 100);
            $table->integer('content_type')->unsigned();
            $table->integer('uploaded_by')->unsigned();
            $table->string('lat', 30);
            $table->string('log', 30);
            $table->string('block', 300)->nullable();
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('post');
    }
};
