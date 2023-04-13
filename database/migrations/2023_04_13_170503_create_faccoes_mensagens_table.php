<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateFaccoesMensagensTable.
 */
class CreateFaccoesMensagensTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faccoes_mensagens', function(Blueprint $table) {
            $table->increments('id');

			// Facção
			$table->integer('FAC_ID')->unsigned();
			$table->foreign('FAC_ID')->references('id')->on('faccoes')->onDelete('cascade');
			// Mensagem da Facção pelo APP
			$table->longText('FAC_MSG_APP');
			// Lote da Mensagem (Se Houver)
			$table->integer('LOTE_ID')->unsigned()->nullable();
			$table->foreign('LOTE_ID')->references('id')->on('lotes_rastreamentos')->onDelete('cascade');

			$table->integer('FAC_MSG_READ')->default(0); // Não Lido

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
		Schema::drop('faccoes_mensagens');
	}
}
