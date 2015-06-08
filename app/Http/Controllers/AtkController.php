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
use App\Atak_Surowce;
use App\Atak;
use Auth;
use DB;

class AtkController extends Controller {

	public function index() {
		$id = Auth::user()->id;

		$ataki = DB::table('ataki')
			->join('porty as ap','atakujacy_port_id','=','ap.id')
			->leftJoin('porty as bp','broniacy_port_id','=','bp.id')
			->where('atakujacy_gracz_id','=',$id)
			->orWhere('broniacy_gracz_id','=',$id)
			->selectRaw("ataki.id as atak_id,
				atakujacy_gracz_id,
				atakujacy_port_id,
				broniacy_gracz_id,
				broniacy_port_id,
				wydarzenie,
				new_port_id,
				status,
				dataBojki,
				dataPowrotu,
				ap.nazwa as a_nazwa,
				bp.nazwa as b_nazwa")
			->orderBy("dataBojki", "DESC")
			->get();

		return view('atak.index', compact('ataki','id'));
	}

	public function deets($atak_id) {
		$id = Auth::user()->id;
		$atak = DB::table('ataki')
			->join('porty as ap','atakujacy_port_id','=','ap.id')
			->leftJoin('porty as bp','broniacy_port_id','=','bp.id')
			->where('ataki.id','=',$atak_id)
			->selectRaw("ataki.id as atak_id,
				atakujacy_gracz_id,
				atakujacy_port_id,
				broniacy_gracz_id,
				broniacy_port_id,
				wydarzenie,
				new_port_id,
				status,
				dataBojki,
				dataPowrotu,
				ap.nazwa as a_nazwa,
				bp.nazwa as b_nazwa")
			->first();

		//0 - gracz atakował i zyskał surowce
		//1 - gracz został napadnięty i stracił surowce
		$nasi = 0;
		if($atak->broniacy_gracz_id == $id && $atak->broniacy_gracz_id != $atak->atakujacy_gracz_id) {
			$nasi = 1;
		} else {
			$nasi = 0;
		}
		
		$straty_ally = DB::table('jednostki as j')
			->leftJoin(DB::raw('(select * 
                             from atak_jednostki
                             where atak_id = '.$atak_id
							.' AND czy_obronca='.$nasi.') as aj '),
							function($join)
							{
							    $join->on('j.id', '=', 'aj.jednostka_id');
							})
			->get();

		$straty_foe = DB::table('jednostki as j')
			->leftJoin(DB::raw('(select * 
                             from atak_jednostki
                             where atak_id = '.$atak_id
							.' AND czy_obronca!='.$nasi.') as aj '),
							function($join)
							{
							    $join->on('j.id', '=', 'aj.jednostka_id');
							})
			->get();

		$surowce = DB::table('surowce as s')
			->leftJoin(DB::raw('(select * 
                             from atak_surowce
                             where atak_id = '.$atak_id.') as ats'),
							function($join)
							{
							    $join->on('s.id', '=', 'ats.surowiec_id');
							})
			->get();

		return view('atak.deets', compact('atak', 'straty_ally', 'straty_foe', 'surowce', 'nasi'));
	}
 
	public function getIndex($varx, $vary)
	{
		$x_param = $varx;
		$y_param = $vary;
		$ind = Session::get('id_akt');
		$jednostki = Jednostka::all();
		
		$port_jednostki = Jednostka::join('port_jednostki',function($join){
			$join->on('port_jednostki.jednostka_id','=','jednostki.id');})
		->where('port_id','=',$ind)
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
		->get();
		
		$amount = $request->input('amount');
	    $i=count($amount);
		$z=0;
		for($x=0; $x<$i; $x++){
			$ilosc=$port_jednostki[$x]->ilosc;
			if($ilosc<$amount[$x]){
				return Redirect::back()->withErrors(trans("validation.custom.atak_jednostki.max"));
			}
			if($amount[$x]<0) {
				return Redirect::back()->withErrors(trans("validation.custom.amount.min"));
			}
			if(!(empty($amount[$x]))){
				$z++;
			}
		}

		$major_general = $request->input('major-general');
		/*UWAGA! Ryzykowny kod!*/
		$ilosc=$port_jednostki[$i]->ilosc;
		/*Zakłada, że Major-Generał będzię ostatnią jednostką!*/
		if($ilosc<$major_general){
			return Redirect::back()->withErrors(trans("validation.custom.atak_jednostki.max"));
		}
		if($major_general<0) {
			return Redirect::back()->withErrors(trans("validation.custom.amount.min"));
		}
		
		if($z==0 && $request->input('colonization') == 0) {
			if($request->input('major-general') == 0) {
				return Redirect::back()->withErrors(trans("validation.custom.atak_jednostki.min"));
			} else {
				return Redirect::back()->withErrors(trans("validation.custom.atak_jednostki.alone"));
			}
		}
		
		$czas0 = Carbon::now();
		$czas1 = Carbon::now()-> addMinutes(3);
		$czas2 = Carbon::now()-> addMinutes(6);
		
		$wyspa = Mapa::where('pos_x','=',$varx)
		->where('pos_y','=',$vary)
		->first();
		$port_cel = Port::where('id','=',$wyspa->port_id)
		->first();
		$port_cel_id = null;
		$obronca = null;
		if($port_cel != null) {
			$obronca = $port_cel->gracz_id;
			$port_cel_id = $port_cel->id;
		}
		$wydarzenie = null;
		if($request->input('colonization') == 1) {
			$wydarzenie = $request->input('newport');
		}
		
		$ataki = Atak::create([
			'atakujacy_gracz_id' =>  Auth::user()->id,
			'broniacy_gracz_id' => $obronca,
			'atakujacy_port_id' => $ind,
			'broniacy_port_id' => $port_cel_id,
			'dataBojki' => $czas1,
			'dataPowrotu' => $czas2,
			'cel_x' => $x_param,
			'cel_y' => $y_param,
			'wydarzenie' => $wydarzenie,
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

		if($request->input('colonization') == 1) {
			$atakJednostki = Atak_Jednostki::create([
				'atak_id' => $ataki->id,
				'jednostka_id' => 100,
				'ilosc_wyjscie' => $request->input('major-general')
					]);

			$iloscObecna = $port_jednostki[$i]->ilosc;
			$odejmij=$iloscObecna-$request->input('major-general');
			
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