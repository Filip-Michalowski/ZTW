<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudynekSurowceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('budynek_surowce', function(Blueprint $table)
		{
			$table->integer('budynek_id')->unsigned();
			$table->foreign('budynek_id')
				  ->references('id')
				  ->on('budynki');
			$table->integer('surowiec_id')->unsigned();
			$table->foreign('surowiec_id')
				  ->references('id')
				  ->on('surowce');

			$table->primary(['budynek_id', 'surowiec_id']);

			//Pozytywny i negatywny przyzrost na minutę
			$table->integer('przyrost');

			//Dla przyszłych rozwiązań
			$table->string('formula')->default('+');

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
		Schema::drop('budynek_surowce');
	}

}
