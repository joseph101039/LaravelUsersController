<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            /* new column for mock api*/
            $table->string('firstName', 5)->nullable();
            $table->string('lastName', 5)->nullable();
            $table->string('city');
            $table->string('address');
            $table->string('tel', 10);
            $table->date('birthday')->nullable();
            $table->string('account')->unique();
            $table->string('password');
            $table->string('photo')->nullable();
            $table->boolean('gender');  // 0 for male, 1 for female
            //$table->json('interest');
            $table->text('interest');



            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();


            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
