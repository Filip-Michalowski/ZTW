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

			$table->integer('atakujacy_gracz_id')->unsigned()->nullable();
			$table->foreign('atakujacy_gracz_id')
				->references('id')
				->on('users')
				->onDelete('set null');

			$table->integer('broniacy_gracz_id')->unsigned()->nullable();
			$table->foreign('broniacy_gracz_id')
				->references('id')
				->on('users')
				->onDelete('set null');

			$table->integer('atakujacy_port_id')->unsigned()->nullable();
			$table->foreign('atakujacy_port_id')
				->references('id')
				->on('porty')
				->onDelete('set null');

			$table->integer('broniacy_port_id')->unsigned()->nullable();
			$table->foreign('broniacy_port_id')
				->references('id')
				->on('porty')
				->onDelete('set null');


			$table->dateTime('dataBojki');
			$table->dateTime('dataPowrotu')->nullable();

			/*
			utwo-
			rzenie
			i
			wyjście | wczytanie | bójka | powrót | całkowicie przeprocesowany
					|		    |       |		 |
					0		    1       2		 3
			4 - dołączenie
			5 - kolonizacja
			*/
			$table->integer('status')->default(0);

			$table->integer('cel_x');
			$table->integer('cel_y');
			
			$table->foreign(['cel_x','cel_y'])
				->references(['pos_x','pos_y'])
				->on('mapy')
				->onDelete('no action');

			//Na przyszłość?: zdarzenia losowe dla wysp bezludnych
			$table->string('wydarzenie')->nullable();

			$table->integer('new_port_id')->unsigned()->nullable();
			$table->foreign('new_port_id')
				->references('id')
				->on('porty')
				->onDelete('set null');

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
