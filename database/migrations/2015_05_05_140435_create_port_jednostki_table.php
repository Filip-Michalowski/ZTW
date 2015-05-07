<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortJednostkiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('port_jednostki', function(Blueprint $table)
			{
			$table->integer('port_id')->unsigned();
			$table->integer('jednostka_id')->unsigned();
			$table->integer('ilosc');
			$table->rememberToken();
			$table->timestamps();

			$table->foreign('port_id')
				  ->references('id')
				  ->on('porty');

			$table->foreign('jednostka_id')
				  ->references('id')
				  ->on('jednostki');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('port_jednostki');
	}

}
