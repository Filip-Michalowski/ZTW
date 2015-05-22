<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtakSurowceTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('atak_surowce', function(Blueprint $table)
		{
			//Tworzone w razie potrzeby
			
			$table->integer('atak_id')->unsigned();
			$table->foreign('atak_id')
				->references('id')
				->on('ataki')
				->onDelete('cascade');

			$table->integer('surowiec_id')->unsigned();
			$table->foreign('surowiec_id')
				  ->references('id')
				  ->on('surowce')
				  ->onDelete('cascade');

		  	$table->primary(['atak_id', 'surowiec_id']);

		  	$table->integer('ilosc')->unsigned()->default(0);


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
		Schema::drop('atak_surowce');
	}

}
