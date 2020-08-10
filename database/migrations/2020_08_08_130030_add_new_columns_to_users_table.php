<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewColumnsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('phone')->nullable();
            $table->string('city')->nullable();
            $table->string('zip')->nullable();
            $table->string('state')->nullable();
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('role_type')->nullable();
            $table->string('user_image')->nullable();
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
        Schema::table('users', function (Blueprint $table) {
            //
            
            $table->dropColumn('phone');
            $table->dropColumn('city');
            $table->dropColumn('zip');
            $table->dropColumn('state');
            $table->dropColumn('address1');
            $table->dropColumn('address2');
            $table->dropColumn('role_type');
            $table->dropColumn('user_image');
        });
    }
}
