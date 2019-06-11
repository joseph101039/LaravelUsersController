<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Users', function (Blueprint $table) {
            // modify the column name from firstName to first_name
            $table->renameColumn('firstName', 'first_name');
            $table->renameColumn('lastName', 'last_name');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Users', function (Blueprint $table) {
            $table->renameColumn('first_name', 'firstName');
            $table->renameColummn('last_name', 'lastName');

        });
    }
}
