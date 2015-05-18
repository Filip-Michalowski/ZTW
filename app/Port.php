<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Port extends Model {

	protected $table = 'porty';
	
	protected $fillable = ['nazwa','gracz_id'];

	public function mapa() {
		return $this->hasOne('App\Mapa');
	}

	public function surowce() {
		return $this->hasMany('App\Port_Surowce');
	}
}
