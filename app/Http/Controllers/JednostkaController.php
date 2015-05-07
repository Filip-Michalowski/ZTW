<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jednostka;
use App\Port_Jednostki;
use Illuminate\Http\Request;

class JednostkaController extends Controller {

	public function index()
	{
		$ind = unserialize($_COOKIE['id_akt']);
		$jednostki = Jednostka::all();

		$port_jednostki = Port_Jednostki::leftjoin('jednostki',function($join){
			$join->on('port_jednostki.jednostka_id','=','jednostki.id');})->where('port_id','=', $ind)
		->get();
		return view('jednostka.index', compact('jednostki','port_jednostki'));
	}

	public  function werbuj($id){
		$ind = unserialize($_COOKIE['id_akt']);
		

		$budpom = Port_Jednostki::where('jednostka_id', $id)-> where('port_id', $ind)->increment('ilosc');
		
		$ind = unserialize($_COOKIE['id_akt']);
		$jednostki = Jednostka::all();

		$port_jednostki = Port_Jednostki::leftjoin('jednostki',function($join){
			$join->on('port_jednostki.jednostka_id','=','jednostki.id');})->where('port_id','=', $ind)
		->get();
		return view('jednostka.index', compact('jednostki','port_jednostki'));

		
	}
}
