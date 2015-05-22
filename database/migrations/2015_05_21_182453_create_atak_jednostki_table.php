<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAtakJednostkiTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('atak_jednostki', function(Blueprint $table)
		{
			$table->integer('atak_id')->unsigned();
			$table->foreign('atak_id')
				->references('id')
				->on('ataki')
				->onDelete('cascade');

			$table->integer('jednostka_id')->unsigned();
			$table->foreign('jednostka_id')
				  ->references('id')
				  ->on('jednostki')
				  ->onDelete('cascade');

			$table->primary(['atak_id', 'jednostka_id']);

			$table->integer('ilosc_wyjscie')->unsigned();
			$table->integer('ilosc_powrot')->unsigned()->nullable();

			$table->boolean('czy_obronca')->default(0);

			//NOTKA: W ramach optymalizacji dać także sumaryczną wartość ataku?

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
		Schema::drop('atak_jednostki');
	}

}
