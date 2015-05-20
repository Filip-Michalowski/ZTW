<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Port extends Model {

	public static function createRand($nazwa_portu, $gracz_id) {
		//przenieś z Registrar
		$port = Port::create([
			'nazwa' => $nazwa_portu,
			'gracz_id' => $gracz_id
		]);

		$liczba = Mapa::where('typ','>','0')->where('port_id','=',null)->count();
		
		$los = rand(0,($liczba-1));

		$mapa = Mapa::where('typ','>','0')->where('port_id','=',null)->orderByRaw("RAND()")->first();
		$mapa->port_id = $port->id;
		$mapa->save();

		$surowce = Surowiec::get();

		foreach($surowce as $sur) {
			$ps = new Port_Surowce;

			$ps->port_id = $port->id;			
			$ps->surowiec_id = $sur->id;

			if($sur->id == 1) {
				$ps->ilosc = 100;
			} else if($sur->id == 2) {
				$ps->ilosc = 3;
			} 

			$ps->save();
		}

		//Na razie przypisuje wszystkie budynki
		$budynki = Budynek::get();

		foreach($budynki as $bud) {
			$pb = new Port_Budynki;

			$pb->port_id = $port->id;			
			$pb->budynek_id = $bud->id;

			$pb->save();
		}

		Surowiec::refresh($port->id);

		//Przypisuje wszystkie jednostki
		$jednostki = Jednostka::get();

		foreach($jednostki as $jed) {
			$pj = new Port_Jednostki;

			$pj->port_id = $port->id;
			$pj->jednostka_id = $jed->id;

			$pj->save();
		}
	}

	protected $table = 'porty';
	
	protected $fillable = ['nazwa','gracz_id'];

	public function mapa() {
		return $this->hasOne('App\Mapa');
	}

	public function surowce() {
		return $this->hasMany('App\Port_Surowce');
	}
}
