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
				  ->on('budynki')
				  ->onDelete('cascade');
			$table->integer('surowiec_id')->unsigned();
			$table->foreign('surowiec_id')
				  ->references('id')
				  ->on('surowce')
				  ->onDelete('cascade');

			$table->primary(['budynek_id', 'surowiec_id']);

			//Pozytywny i negatywny przyzrost na minutę
			$table->decimal('rate',8,2)->default(0);

			//Wielkość magazynu
			$table->integer('magazyn')->default(0);

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
