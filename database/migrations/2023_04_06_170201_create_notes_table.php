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
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->integer('website_id');
            $table->integer('status')->default(0);
            $table->text('internal_notes')->nullable();
            $table->text('client_notes')->nullable();
            $table->text('title_notes')->nullable();
            $table->text('description_notes')->nullable();
            $table->text('feature_notes')->nullable();
            $table->text('specification_notes')->nullable();
            $table->text('image_notes')->nullable();
            $table->text('overall_notes')->nullable();
            $table->text('category')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notes');
    }
};
