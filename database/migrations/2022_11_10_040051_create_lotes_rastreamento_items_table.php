<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotesRastreamentoItemsTable.
 */
class CreateLotesRastreamentoItemsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lotes_rastreamento_items', function(Blueprint $table) {
            $table->increments('id');

			// Lote que vincula o item
			$table->integer('LOTE_ID')->unsigned()->nullable();
			$table->foreign('LOTE_ID')->references('id')->on('lotes_rastreamentos')->onDelete('cascade');

			$table->string('LOTE_ITEM_IDENTIFY'); // CÓDIGO DE BARRAS PARA LEITURA DE IDENTIFICAÇÃO
			$table->integer('LOTE_ITEM_STATUS')->default(0); // 0 - CRIADO | 1 - EM PRODUÇÃO | 2 - COMPLETA

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
		Schema::drop('lotes_rastreamento_items');
	}
}
