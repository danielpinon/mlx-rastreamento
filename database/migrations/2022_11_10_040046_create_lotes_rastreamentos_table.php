<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotesRastreamentosTable.
 */
class CreateLotesRastreamentosTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lotes_rastreamentos', function(Blueprint $table) {
            $table->increments('id');

			// Facção Vinculada
			$table->integer('FAC_ID')->unsigned()->nullable();
			$table->foreign('FAC_ID')->references('id')->on('faccoes')->onDelete('cascade');

			// Informações do Lote
			$table->string('LOTE_DESC_SMALL')->nullable();
			$table->uuid('LOTE_TOKEN'); //Token Único do Lote
			$table->integer('LOTE_STATUS')->default(0); // 0 - CRIADO | 1 - EM PRODUÇÃO | 2 - CONCLUÍDO
			$table->integer('LOTE_QNT_ITENS');
			$table->longText('LOTE_BIG_DESC')->nullable();

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
		Schema::drop('lotes_rastreamentos');
	}
}
