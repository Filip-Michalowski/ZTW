<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePortBudynkiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('port_budynki', function(Blueprint $table)
		{
			$table->integer('port_id')->unsigned();
			$table->integer('budynek_id')->unsigned();
			$table->integer('poziom');
			$table->rememberToken();
			$table->timestamps();

			$table->foreign('port_id')
				  ->references('id')
				  ->on('porty');

			$table->foreign('budynek_id')
				  ->references('id')
				  ->on('budynki');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('port_budynki');
	}

}
