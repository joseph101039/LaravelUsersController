<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Projects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('projects', function(Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('project_name')->unique();
            $table->bigInteger('user_id')->unsigned();
            $table->text('description');
            $table->timestamps();

            //$table->primary('id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists("projects");
    }
}
