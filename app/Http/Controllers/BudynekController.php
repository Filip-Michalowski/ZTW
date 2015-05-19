<?php namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Budynek;
use App\Port;
use App\Port_Budynki;
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
		$port_budynki = Port_Budynki::leftjoin('budynki',function($join){
			$join->on('port_budynki.budynek_id','=','budynki.id');})->where('port_id','=', $ind)
		->get();
		return view('budynek.index', compact('port_budynki'));
	}

	public function update($id){
		$ind = Session::get('id_akt');

		/**///DODAĆ TO
		//$prawdziwy_koszt = ;

		$budpom = Port_Budynki::where('budynek_id', $id)-> where('port_id', $ind)->increment('poziom');
		return Redirect::action('BudynekController@index');
	}


}
