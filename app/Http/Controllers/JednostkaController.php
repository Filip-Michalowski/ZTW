<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jednostka;
use App\Port_Jednostki;
use App\Surowiec;
use App\Port_Surowce;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use \Cache;

class JednostkaController extends Controller {

	public function index()
	{
		//$ind = unserialize($_COOKIE['id_akt']);
		$ind = Session::get('id_akt');
		$jednostki = Jednostka::all();
		
		$port_jednostki = Jednostka::join('port_jednostki',function($join){
			$join->on('port_jednostki.jednostka_id','=','jednostki.id');})
		->where('port_id','=',$ind)
		->with('koszty')
		->get();
		
		//->orWhere('port_id','=', null) jest już niepotrzebne

		return view('jednostka.index', compact('jednostki','port_jednostki'));
	}

	public  function werbuj($id){
		$ind = Session::get('id_akt');

		Surowiec::refresh($ind);

		$poj = Jednostka::join('port_jednostki',function($join){
			$join->on('port_jednostki.jednostka_id','=','jednostki.id');})
		->where('port_id','=',$ind)
		->where('jednostka_id','=',$id)
		->with('koszty')
		->first();

		$sur = Port_Surowce::where('port_id',$ind)->get();

		$stac_na = true;
		
		foreach($poj->koszty as $koszt) {
			if($koszt->koszt > $sur[$koszt->surowiec_id - 1]->ilosc) {
				$stac_na = false;
			}
		}

		if($stac_na) {
			foreach($poj->koszty as $koszt) {
				Surowiec::inout($ind,$koszt->surowiec_id,(-1) * $koszt->koszt);
			}
			Port_Jednostki::where('jednostka_id', $id)-> where('port_id', $ind)->increment('ilosc');
			return Redirect::action('JednostkaController@index');
		} else {
			return Redirect::action('JednostkaController@index')->withErrors(trans("validation.custom.jednostka.not_enough").trans("messages.".$poj->nazwa).'.');
		}
	}

}
