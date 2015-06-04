<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Budynek;
use App\Port;
use App\Port_Budynki;
use App\Surowiec;
use App\Port_Surowce;
use App\Gracz_Porty;
use App\HomeController;
use Session;
use Cache;
use Cookie;

use Illuminate\Http\Request;

class BudynekController extends Controller {

	public function index()
	{
		$budynki = Budynek::all();
		$porty = Port::all();
		$ind = Session::get('id_akt');
		$port_budynki = Budynek::join('port_budynki',function($join){
			$join->on('port_budynki.budynek_id','=','budynki.id');})
		->where('port_id','=', $ind)
		->with('koszty')
		->get();
		return view('budynek.index', compact('port_budynki'));
	}

	public function update($id){
		$ind = Session::get('id_akt');

		Surowiec::refresh($ind);

		$pob = Budynek::join('port_budynki',function($join){
			$join->on('port_budynki.budynek_id','=','budynki.id');})
		->where('port_id','=',$ind)
		->where('budynek_id','=',$id)
		->with('koszty')
		->first();

		$sur = Port_Surowce::where('port_id',$ind)->get();

		$stac_na = true;

		foreach($pob->koszty as $koszt) {
			if($koszt->koszt * ($pob->poziom + 1) > $sur[$koszt->surowiec_id - 1]->ilosc) {
				$stac_na = false;
			}
		}

		if($stac_na) {
			foreach($pob->koszty as $koszt) {
				Surowiec::inout($ind,$koszt->surowiec_id,(-1) * ($pob->poziom + 1) * $koszt->koszt);
			}
			Port_Budynki::where('budynek_id', $id)-> where('port_id', $ind)->increment('poziom');
			Surowiec::refresh($ind);
			return Redirect::action('BudynekController@index');
		} else {
			return Redirect::action('BudynekController@index')->withErrors(trans("validation.custom.budynek.not_enough").trans("messages.".$pob->nazwa).'.');
		}
	}

}
