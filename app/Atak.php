<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Atak extends Model {

	protected $table('ataki');

	public function jednostki() {
		return $this->hasMany('App\Atak_Jednostki');
	}

	public function surowce() {
		return $this->hasMany('App\Atak_Surowce');
	}

	public function mapa() {
		return $this->belongsTo('App\Mapa');
	}
}
