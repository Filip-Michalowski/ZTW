<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Surowiec;
use App\Port;
use App\Port_Surowce;
use App\Port_Budynki;
use App\Budynek_Surowce;
use Session;
use Illuminate\Http\Request;

class SurowiecController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//Stare:
		/*$surowce = Surowiec::all();
		return view('surowiec.index',compact('surowce'));*/

		$port_id = Session::get('id_akt');

		$surowce = Surowiec::all();
		
		$port_surowce = Surowiec::join('port_surowce','surowce.id','=', 'port_surowce.surowiec_id', 'left outer')
			->where('port_surowce.port_id','=', $port_id)
			->orWhere('port_surowce.port_id','=', null)
			->orderBy('id')
			->get();

		return view('surowiec.index',compact('surowce','port_surowce','port_id'));		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $port_id
	 * @return Response
	 */
	public function update($port_id)
	{
		//gdzie $id to id portu

		$port_budynki = Port_Budynki::where('port_id','=',$port_id)
			->join('budynek_surowce','budynek_surowce.budynek_id','=','port_budynki.budynek_id')
			->get();

		/*foreach ($port_budynki as $pb) {
			# code...
			echo $pb->budynek_id.'<br/>';
		}*/

		//echo '<br/>';

		$port_surowce = Port_Surowce::where('port_id','=',$port_id)
			->get();

		/*foreach ($port_surowce as $pb) {
			# code...
			echo $pb->surowiec_id.'<br/>';
		}*/

		//echo('the Dolphin<br/><br/>');

		$updated_at = time();

		//Do przyszłej optymalizacji...?
		foreach ($port_surowce as $ps) {
			$tally = 0;
			foreach ($port_budynki as $pb) {
				//echo '-- '.$pb->budynek_id.'<br/>';
				if($pb->surowiec_id == $ps->surowiec_id) {
					$tally += $pb->rate;
				}
			}
			//Obliczenie nowego zapasu
			$ilosc = $ps->ilosc
		 		+ ( $updated_at - strtotime($ps->updated_at) )
			 	/60
	 		 	* $ps->rate;
			//echo 'surowiec #'.$ps->surowiec_id.'='.$ilosc.'<br/>';

			Port_Surowce::where('port_id','=',$ps->port_id)
				->where('surowiec_id','=',$ps->surowiec_id)
				->update([
					'ilosc' => $ilosc,
					'updated_at' => $updated_at
				]);

			/*$ps->updated_at = $updated_at;
			$ps->ilosc = $ilosc;
			$ps->save();*/			
		}
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
