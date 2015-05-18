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
<<<<<<< HEAD:database/migrations/2015_04_27_154355_create_mapy_table.php
=======
			$table->integer('pos_x');
			$table->integer('pos_y');
			$table->integer('port_id')->unsigned()->nullable();
			//typ == 0 - woda
			//typ == 1 - wyspa
			$table->integer('typ')->unsigned()->default(0);
>>>>>>> origin/mapy_eksperymentalna:database/migrations/2015_04_27_003825_create_mapy_table.php
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
		Schema::drop('mapy');
	}

}
