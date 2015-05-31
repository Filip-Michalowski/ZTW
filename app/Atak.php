<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Atak extends Model {

	protected $table='ataki';
	
	protected $fillable = ['atakujacy_gracz_id',
			'broniacy_gracz_id',
			'atakujacy_port_id',
			'broniacy_port_id',
			'dataBojki',
			'dataPowrotu',
			'cel_x',
			'cel_y',
			'wydarzenie'];

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
