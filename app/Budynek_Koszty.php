<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Budynek_Koszty extends Model {

	protected $table = 'budynek_koszty';

	public function budynek() {
		return $this->belongsTo('App\Budynek');
	}

	public function surowiec() {
		return $this->belongsTo('App\Surowiec');
	}
}
