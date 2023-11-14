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
        Schema::create('website_ranges', function (Blueprint $table) {
            $table->id();
            $table->integer('website_id');
            $table->string('content');
            $table->integer('high_attention_required');
            $table->integer('needs_improvement');
            $table->integer('good_to_improve');
            $table->integer('average_optimized');
            $table->integer('optimized');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('website_ranges');
    }
};
