<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBudynekKosztyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('budynek_koszty', function(Blueprint $table)
		{
			$table->integer('budynek_id')->unsigned();
			$table->foreign('budynek_id')
				  ->references('id')
				  ->on('budynki');
			$table->integer('surowiec_id')->unsigned();
			$table->foreign('surowiec_id')
				  ->references('id')
				  ->on('surowce');

		  	$table->primary(['budynek_id', 'surowiec_id']);

		  	$table->integer('koszt')->unsigned();

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
		Schema::drop('budynek_koszty');
	}

}
