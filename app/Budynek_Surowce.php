<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Budynek_Surowce extends Model {

	protected $table = 'budynek_surowce';

	public function budynek() {
		return $this->belongsTo('App\Budynek');
	}

	public function surowiec() {
		return $this->belongsTo('App\Surowiec');
	}
}
