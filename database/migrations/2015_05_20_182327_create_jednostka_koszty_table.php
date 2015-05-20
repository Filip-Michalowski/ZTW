<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJednostkaKosztyTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('jednostka_koszty', function(Blueprint $table)
		{
			//$table->increments('id');
			$table->integer('jednostka_id')->unsigned();
			$table->foreign('jednostka_id')
				  ->references('id')
				  ->on('jednostki')
				  ->onDelete('cascade');

			$table->integer('surowiec_id')->unsigned();
			$table->foreign('surowiec_id')
				  ->references('id')
				  ->on('surowce')
				  ->onDelete('cascade');

		  	$table->primary(['jednostka_id','surowiec_id']);

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
		Schema::drop('jednostka_koszty');
	}

}
