<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebsitesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('websites', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('client_id');
            $table->string('first_name');
            $table->string('last_name')->nullable();
            $table->string('email');
            $table->string('company_name');
            $table->string('website');
            $table->text('description')->nullable();
            $table->integer('status')->default(0);
            $table->string('platform')->nullable();
            $table->string('platform_details')->nullable();
            $table->string('workflow_settings')->nullable();
            $table->integer('project_status')->nullable();
            $table->string('reason')->nullable();
            $table->integer('download_image')->nullable();
            $table->integer('download_asset')->nullable();
            $table->integer('time_track')->nullable();
            $table->integer('enhance_status')->default(0);
            $table->integer('post_payment_status')->default(0);
            $table->string('post_payment_id')->nullable();
            $table->string('validation_status')->nullable();
            $table->text('remark')->nullable();
            $table->integer('parent_id')->nullable();
            $table->integer('ops_id')->nullable();
            $table->integer('tl_id')->nullable();
            $table->timestamp('tl_assigned_at')->nullable();
            $table->integer('title_status')->default(1);
            $table->integer('description_status')->default(1);
            $table->integer('feature_status')->default(1);
            $table->integer('specification_status')->default(1);
            $table->integer('image_status')->default(1);
            $table->string('sku_file')->nullable();
            $table->string('audit')->nullable();
            $table->string('category')->nullable();
            $table->string('comments')->nullable();
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
        Schema::dropIfExists('websites');
    }
}
