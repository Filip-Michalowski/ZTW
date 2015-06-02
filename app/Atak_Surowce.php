<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Atak_Surowce extends Model {

	protected $table('atak_surowce');

	public function atak() {
		return $this->belongsTo('App\Atak');
	}

	public function surowiec() {
		return $this->belongsTo('App\Surowiec');
	}
}
