<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateLotesRastreamentoItemSetorsTable.
 */
class CreateLotesRastreamentoItemSetorsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lotes_rastreamento_item_setors', function(Blueprint $table) {
            $table->increments('id');

			// Vincula ao item do lote
			$table->integer('LOTE_ITEM_ID')->unsigned()->nullable();
			$table->foreign('LOTE_ITEM_ID')->references('id')->on('lotes_rastreamento_items')->onDelete('cascade');
			
			// Vincula ao setor do item
			$table->integer('SETOR_ID')->unsigned()->nullable();
			$table->foreign('SETOR_ID')->references('id')->on('setores')->onDelete('cascade');

			$table->integer('STATUS')->default(0); // 0 - INICIADO/OPERACAO | 1 - COMPLETO 
			$table->dateTime('INIT')->nullable(); // Entrada
			$table->dateTime('EXIT')->nullable(); // Saída


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
		Schema::drop('lotes_rastreamento_item_setors');
	}
}
