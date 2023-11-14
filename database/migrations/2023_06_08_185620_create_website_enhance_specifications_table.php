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
        Schema::create('website_enhance_specifications', function (Blueprint $table) {
            $table->id();
            $table->integer('website_id');
            $table->integer('website_enhance_data_id');
            $table->text('specification_head')->nullable();
            $table->text('specification_value')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_enhance_specifications');
    }
};
