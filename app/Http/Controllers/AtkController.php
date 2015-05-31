<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Jednostka;
use App\Port_Jednostki;
use App\Surowiec;
use App\Port_Surowce;
use App\Mapa;
use App\Port;
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

		$wyspa = Mapa::where('pos_x','=',$varx)
		->where('pos_y','=',$vary)
		->first();

		return view('mapa.atform', compact('jednostki','port_jednostki','wyspa'));
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
		
		
		
		$amount = $request->input('amount');
	    $i=count($amount);
		$z=0;
		for($x=0; $x<$i; $x++){
			$ilosc=$port_jednostki[$x]->ilosc;
			if($ilosc<$amount[$x]){
				return Redirect::back()->withErrors('Nie możesz wysłać więcej jednostek niż posiadasz');
			}
			if(!(empty($amount[$x]))){
				$z++;
			}
		}
		
		if($z==0 && $request->input('colonization') == 0){
			return Redirect::back()->withErrors('Musisz wysłać przynajmniej jedną jednostkę, aby przeprowadzić atak');
		}
		
		$czas0 = Carbon::now();
		$czas1 = Carbon::now()-> addMinutes(3);
		$czas2 = Carbon::now()-> addMinutes(6);
		
		$wyspa = Mapa::where('pos_x','=',$varx)
		->where('pos_y','=',$vary)
		->first();
		$port_cel = Port::where('id','=',$wyspa->port_id)
		->first();
		$obronca = null;
		if($port_cel != null) {
			$obronca = $port_cel->gracz_id;
		}



		$ataki = Atak::create([
			'atakujacy_gracz_id' =>  Auth::user()->id,
			'broniacy_gracz_id' => $obronca,
			'atakujacy_port_id' => $ind,
			'broniacy_port_id' => $port_cel,
			'dataBojki'=> $czas1,
			'dataPowrotu'=> $czas2,
			'cel_x'=> $x_param,
			'cel_y'=> $y_param,
		]);
		
		
		for($x=0; $x<$i; $x++){
			if(!(empty($amount[$x]))){	
				$atakJednostki = Atak_Jednostki::create([
				'atak_id' => $ataki->id,
				'jednostka_id' => $x+1,
				'ilosc_wyjscie' => $amount[$x]
					]);

	            $iloscObecna=$port_jednostki[$x]->ilosc;	
				$odejmij=$iloscObecna-$amount[$x];		
				
				Port_Jednostki::where('port_id','=',$ind)
					->where('jednostka_id','=',$x+1)
					->update([
						'ilosc' => $odejmij,
						'updated_at' => date($czas0)
				]);
			}
		}

		if(!(empty($request->input('major_general')))) {
			$atakJednostki = Atak_Jednostki::create([
				'atak_id' => $ataki->id,
				'jednostka_id' => 100,
				'ilosc_wyjscie' => $request->input('major_general')
					]);

			$iloscObecna = $port_jednostki[100]->ilosc;
			$odejmij=$iloscObecna-$request->input('major_general');
			
			Port_Jednostki::where('port_id','=',$ind)
				->where('jednostka_id','=',100)
				->update([
					'ilosc' => $odejmij,
					'updated_at' => date($czas0)
			]);
		}
	
			
		return Redirect::action('MapaController@index');
	}
	
}