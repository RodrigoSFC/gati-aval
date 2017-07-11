<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_contacts', function (Blueprint $table) {
			$table->increments('id');
			$table->string('nome', 255);
			$table->string('telefone', 20)->nullable();
			$table->string('email', 255)->nullable();
			$table->string('setor', 50)->index();
			$table->integer('user_id');
			$table->integer('created_user_id');
			$table->integer('updated_user_id');
			$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users_contacts');
    }
}
