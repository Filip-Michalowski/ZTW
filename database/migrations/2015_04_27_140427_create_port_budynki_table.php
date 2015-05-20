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

			$table->primary(['port_id','budynek_id']);

			$table->integer('poziom')->default(0);
			$table->rememberToken();
			$table->timestamps();

			$table->foreign('port_id')
				  ->references('id')
				  ->on('porty')
				  ->onDelete('cascade');

			$table->foreign('budynek_id')
				  ->references('id')
				  ->on('budynki')
				  ->onDelete('cascade');
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
