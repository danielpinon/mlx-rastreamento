<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFaccoesTable.
 */
class CreateFaccoesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faccoes', function(Blueprint $table) {
            $table->increments('id');

			$table->string('FAC_NAME')->nullable();
			$table->uuid('FAC_TOKEN');
			$table->integer('FAC_STATUS')->nullable()->default(1); // 0 - Desativada | 1 - Ativa

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
		Schema::drop('faccoes');
	}
}
