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
use App\Http\Requests\AtRequest;
use Carbon\Carbon;
use App\Atak_Jednostki;
use App\Atak;
use Auth;

class AtkController extends Controller {

 
	public function getIndex($varx, $vary)
	{
		$x_param = $varx;
		$y_param = $vary;
		$ind = Session::get('id_akt');
		$jednostki = Jednostka::all();
		
		$port_jednostki = Jednostka::join('port_jednostki',function($join){
			$join->on('port_jednostki.jednostka_id','=','jednostki.id');})
		->where('port_id','=',$ind)
		->with('koszty')
		->get();

		return view('mapa.atform', compact('jednostki','port_jednostki'));
	}
	
	public function postIndex(AtRequest $request,$varx, $vary)
	{
		$x_param = $varx;
		$y_param = $vary;
		$ind = Session::get('id_akt');
		$jednostki = Jednostka::all();
		
		$port_jednostki = Jednostka::join('port_jednostki',function($join){
			$join->on('port_jednostki.jednostka_id','=','jednostki.id');})
		->where('port_id','=',$ind)
		->with('koszty')
		->get();
		
		
		
		$name = $request->input('name');
	    $i=count($name);
		$z=0;
		for($x=0; $x<$i; $x++){
			$ilosc=$port_jednostki[$x]->ilosc;
			if($ilosc<$name[$x]){
				return Redirect::back()->withErrors('Nie możesz wysłać więcej jednostek niż posiadasz');
			}
			if(!(empty($name[$x]))){
				$z++;
			}
		}
		
		if($z==0){
			return Redirect::back()->withErrors('Musisz wysłać przynajmniej jedną jednostkę, aby przeprowadzić atak');
		}
		
		
		$czas1 = Carbon::now()-> addMinutes(30);
		$czas2 = Carbon::now()-> addMinutes(60);
	
		$ataki = Atak::create([
			'atakujacy_gracz_id' =>  Auth::user()->id,
			'atakujacy_port_id' => $ind,
			'dataBojki'=> $czas1,
			'dataPowrotu'=> $czas2,
			'cel_x'=> $x_param,
			'cel_y'=> $y_param,
		]);
		
		
		for($x=0; $x<$i; $x++){
			if(!(empty($name[$x]))){	
			$atakJednostki = Atak_Jednostki::create([
			'atak_id' => $ataki->id,
			'jednostka_id' => $x+1,
			'ilosc_wyjscie' => $name[$x]
				]);
			}
		}
	
			
		return Redirect::action('MapaController@index');
	}
	
}