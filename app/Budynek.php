<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Budynek extends Model {

	protected $table = 'budynki';

	public function koszt() {
		return $this->hasMany('App\Budynek_Koszty');
	}

	public function produkcja() {
		return $this->hasMany('App\Budynek_Surowce');
	}
}
