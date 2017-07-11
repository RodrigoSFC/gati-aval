<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateForeignKeys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {		
		Schema::table('user_validation', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
        });
		
		Schema::table('users_contacts', function($table) {
			$table->foreign('user_id')->references('id')->on('users');
			$table->foreign('created_user_id')->references('id')->on('users');
			$table->foreign('updated_user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {		
		Schema::table('user_validation', function($table) {
			$table->dropForeign('user_validation_user_id_foreign');
        });
		
		Schema::table('users_contacts', function($table) {
			$table->dropForeign('users_contacts_created_user_id_foreign');
			$table->dropForeign('users_contacts_updated_user_id_foreign');
        });
    }
}
