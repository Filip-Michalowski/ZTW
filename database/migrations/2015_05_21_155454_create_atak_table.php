<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtakTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ataki', function(Blueprint $table)
		{
			$table->increments('id');
			//$table->dateTime('dataWyjscia');
			$table->dateTime('dataBojki');
			$table->dateTime('dataPowrotu');

			/*
			utwo-
			rzenie
			i
			wyjście | wczytanie | bójka | powrót | całkowicie przeprocesowany
					|		    |       |		 |
					0		    1       2		 3
			*/
			$table->integer('status')->default(0);

			$table->integer('cel_x');
			$table->integer('cel_y');
			
			$table->foreign(['cel_x','cel_y'])
				->references(['pos_x','pos_y'])
				->on('mapy');

			//Na przyszłość?: zdarzenia losowe dla wysp bezludnych
			$table->integer('wydarzenie')->unsigned()->nullable():


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
		Schema::drop('ataki');
	}

}
