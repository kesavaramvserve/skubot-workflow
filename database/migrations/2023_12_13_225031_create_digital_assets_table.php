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
        Schema::create('digital_assets', function (Blueprint $table) {
            $table->id();
            $table->integer('website_enhance_data_id');
            $table->string('file_type');
            $table->string('file_url')->nullable();
            $table->string('file_name')->nullable();
            $table->integer('is_manual_upload')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('digital_assets');
    }
};
