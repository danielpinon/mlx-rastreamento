<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateSetoresTable.
 */
class CreateSetoresTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('setores', function(Blueprint $table) {
            $table->increments('id');

			$table->integer('SETOR_ORDEM');
			$table->string('SETOR_NAME')->nullable();
			$table->uuid('SETOR_TOKEN')->nullable();
			$table->integer('SETOR_STATUS')->nullable()->default(1); // 0 - Desativada | 1 - Ativa
			$table->integer('SETOR_STATUS_EXCLUSIVE_MLX')->nullable()->default(0); // 0 - Desativada | 1 - Ativa


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
		Schema::drop('setores');
	}
}
