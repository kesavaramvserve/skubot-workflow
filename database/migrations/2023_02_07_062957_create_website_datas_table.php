<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsiteDatasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('website_datas', function (Blueprint $table) {
            $table->id();
            $table->integer('website_id');
            $table->integer('status')->default(0);
            $table->integer('batch_id')->nullable();
            $table->string('supplier_type')->nullable();
            $table->integer('tl_id')->nullable();
            $table->integer('pa_id')->nullable();
            $table->integer('qc_id')->nullable();
            $table->integer('da_id')->nullable();
            $table->integer('qa_id')->nullable();
            $table->timestamp('pa_approved_at')->nullable();
            $table->timestamp('qc_approved_at')->nullable();
            $table->timestamp('da_approved_at')->nullable();
            $table->timestamp('qa_approved_at')->nullable();
            $table->integer('pa_done')->default(0);
            $table->integer('qc_done')->default(0);
            $table->integer('da_done')->default(0);
            $table->integer('qa_done')->default(0);
            $table->text('summary')->nullable();
            $table->text('rework')->nullable();
            $table->text('title')->nullable();
            $table->text('description')->nullable();
            $table->string('title_metadata')->nullable();
            $table->string('description_metadata')->nullable();
            $table->string('keywords_metadata')->nullable();
            $table->integer('title_metadata_length')->nullable();
            $table->integer('description_metadata_length')->nullable();
            $table->double('keywords_metadata_length')->nullable();
            $table->double('rating')->nullable();
            $table->integer('rating_count')->nullable();
            $table->integer('qa_count')->nullable();
            $table->string('brand')->nullable();
            $table->text('category')->nullable();
            $table->string('stock')->nullable();
            $table->integer('title_character_count');
            $table->integer('description_word_count');
            $table->integer('feature_count');
            $table->integer('specification_count');
            $table->integer('image_count');
            $table->text('url')->nullable();
            $table->text('p_id')->nullable();
            $table->string('mpn')->nullable();
            $table->text('tag')->nullable();
            $table->text('name_error')->nullable();
            $table->text('caption_error')->nullable();
            $table->text('manf_error')->nullable();
            $table->text('image_error')->nullable();
            $table->text('path_error')->nullable();
            $table->text('other_error')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('website_datas');
    }
}
