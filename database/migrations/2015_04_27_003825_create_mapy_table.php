<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mapy', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('pos_x');
			$table->integer('pos_y');
			$table->integer('port_id')->unsigned()->nullable();
			//typ == 0 - woda
			//typ == 1 - wyspa
			$table->integer('typ')->unsigned()->default(0);
			$table->timestamps();

			$table->foreign('port_id')
				->references('id')->on('porty')
				->onDelete('cascade');

			$table->index('pos_x');
			$table->index('pos_y');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('mapy');
	}

}
