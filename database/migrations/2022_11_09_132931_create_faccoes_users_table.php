<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFaccoesUsersTable.
 */
class CreateFaccoesUsersTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faccoes_users', function(Blueprint $table) {
            $table->increments('id');

			$table->integer('FAC_ID')->unsigned()->nullable();
			$table->foreign('FAC_ID')->references('id')->on('faccoes')->onDelete('cascade');
			$table->integer('USER_ID')->unsigned()->nullable();
			$table->foreign('USER_ID')->references('id')->on('users')->onDelete('cascade');

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
		Schema::drop('faccoes_users');
	}
}
