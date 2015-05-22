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
			//laravel wymaga istnienia takiego pola, by móc użyć jednej z wbudowanych funkcji.
			$table->integer('id');
			$table->unique('id');

			$table->integer('pos_x');
			$table->integer('pos_y');

			$table->primary(['pos_x', 'pos_y']);

			$table->integer('port_id')->unsigned()->nullable();

			$table->foreign('port_id')
				  ->references('id')
				  ->on('porty')
				  ->onDelete('set null');

			//typ == 0 - woda
			//typ == 1 - wyspa
			$table->integer('typ')->unsigned()->default(0);
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
