<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->boolean('gender');
            $table->datetime('birthday');
            $table->text('description')->nullable();
            $table->string('profile_image_path')->nullable();
            $table->datetime('joined_company_date')->nullable();
            $table->datetime('joined_project_date')->nullable();
            $table->string('address')->nullable();
            $table->string('station')->nullable();
            $table->string('club')->nullable();
            $table->string('github_url')->nullable();
            $table->string('workplace_url')->nullable();
            $table->boolean('spouse')->default(0);
            $table->string('department')->nullable();
            $table->string('position')->nullable();
            $table->string('job_type')->nullable();
            $table->boolean('waiting_flg')->default(0);
            $table->timestamps();
            $table->datetime('deleted_at')->nullable()->default(null);
            // FK規約
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
