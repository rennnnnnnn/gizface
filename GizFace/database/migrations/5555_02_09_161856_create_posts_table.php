<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->integer('post_category_id')->unsigned();
            $table->string('title');
            $table->text('body');
            $table->string('image_path')->nullable();
            $table->biginteger('reply_count')->default(0);
            $table->biginteger('retweet_count')->default(0);
            $table->biginteger('favorite_count')->default(0);
            $table->string('created_user')->nullable();
            $table->string('updated_user')->nullable();
            $table->timestamps();
            $table->datetime('deleted_at')->nullable()->default(null);
            // FK規約
            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles');
            // FK規約
            $table->foreign('post_category_id')
                ->references('id')
                ->on('post_categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
