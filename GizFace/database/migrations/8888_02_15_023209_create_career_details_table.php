<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCareerDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('career_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('career_id')->unsigned();
            $table->integer('profile_id')->unsigned();
            $table->integer('skill_master_id')->unsigned();
            $table->timestamps();
            // FK規約
            $table->foreign('profile_id')
                ->references('id')
                ->on('profiles');
            $table->foreign('career_id')
                ->references('id')
                ->on('careers');
            $table->foreign('skill_master_id')
                ->references('id')
                ->on('skill_masters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('career_details');
    }
}
