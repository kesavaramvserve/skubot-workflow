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
        Schema::create('website_enhance_images', function (Blueprint $table) {
            $table->id();
            $table->integer('website_id');
            $table->integer('website_enhance_data_id');
            $table->text('image');
            $table->double('width')->nullable();
            $table->double('height')->nullable();
            $table->double('size')->nullable();
            $table->string('alt')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_enhance_images');
    }
};
