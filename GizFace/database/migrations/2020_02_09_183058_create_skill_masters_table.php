<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSkillMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skill_masters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned();
            $table->string('skill');
            $table->timestamps();
            $table->string('created_user')->nullable();
            $table->string('updated_user')->nullable();
            $table->datetime('deleted_at')->nullable()->default(null);
            // FK規約
            $table->foreign('category_id')
                ->references('id')
                ->on('category_masters');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_masters');
    }
}
