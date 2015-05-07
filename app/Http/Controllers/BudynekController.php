<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Budynek;
use App\Port;
use App\Port_Budynki;
use App\Gracz_Porty;
use App\HomeController;

use Illuminate\Http\Request;

class BudynekController extends Controller {

	public function index()
	{
		//session_start();
		$budynki = Budynek::all();
		$porty = Port::all();
		$ind = unserialize($_COOKIE['id_akt']);
		// $port_budynki = Port_Budynki:: where('port_id', '=','2')->get();
		$port_budynki = Port_Budynki::leftjoin('budynki',function($join){
			$join->on('port_budynki.budynek_id','=','budynki.id');})->where('port_id','=', $ind)
		->get();
		
		// $port_budynki = Port_Budynki::
		// 	 where('port_id', '=','2')-> join($budynki,'budynki.id','=','port_budynki.budynek_id')
		//  ->get();
		// $lista = $port_budynki->join($budynki,'budynki.id','=','port_budynki.budynek_id')-> get();
		return view('budynek.index', compact('port_budynki'));
	}

	// public function get_building(){

	// 	$port_budynki = Port_Budynki::leftjoin('budynki',function($join){
	// 		$join->on('port_budynki.budynek_id','=','budynki.id');})->where('port_id','=','2')
	// 	->get();
	// 	return $port_budynki;
	// }

	public  function update($id){
		$ind = unserialize($_COOKIE['id_akt']);
		$rules = array('port_id' => 'required', 
						'budynek_id' => 'required',
						'poziom' =>'required');

		$budpom = Port_Budynki::where('budynek_id', $id)-> where('port_id', $ind)->increment('poziom');
		
		

		$port_budynki = Port_Budynki::leftjoin('budynki',function($join){
			$join->on('port_budynki.budynek_id','=','budynki.id');})->where('port_id','=', $ind)
		->get();
		return view('budynek.index', compact('port_budynki'));
	}

}
