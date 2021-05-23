<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->unsigned();
            $table->datetime('from');
            $table->datetime('to')->nullable();
            $table->string('company');
            $table->string('job_title');
            $table->text('job_detail');
            $table->integer('team_scale');
            $table->integer('sort')->index();
            $table->timestamps();
            $table->datetime('deleted_at')->nullable()->default(null);
            // FK規約
            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('careers');
    }
}
