<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Mapa;
use App\Port;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Session;
use Cache;

class MapaController extends Controller {
	//Na razie wszystkie mogą przyjmować całkowite wartości z zakresu [0,50)

	public function index()
	{
		if(Session::has('lower_bond_x')) {
			$lower_bond_x = Session::get('lower_bond_x',0);
			$lower_bond_y = Session::get('lower_bond_y',0);
		} else {
			return Redirect::to('/mapa/center');
		}
		
		if(is_null($lower_bond_x) && is_null($lower_bond_y)) {
			$lower_bond_x = 0;
			$lower_bond_y = 0;
		} else {
			if($lower_bond_x < 0) {
				$lower_bond_x = 0;
			}
			else if($lower_bond_x > 49 - 6) {
				$lower_bond_x = 49 - 6;
			}

			if($lower_bond_y < 0) {
				$lower_bond_y = 0;
			}
			else if($lower_bond_y > 49 - 6) {
				$lower_bond_y = 49 - 6;
			}
		}

		$upper_bond_x = $lower_bond_x + 6;
		$upper_bond_y = $lower_bond_y + 6;

		$mapy = Mapa::where('pos_x', '>=', $lower_bond_x)
			->where('pos_x', '<=', $upper_bond_x)
			->where('pos_y', '>=', $lower_bond_y)
			->where('pos_y', '<=', $upper_bond_y)
			->orderBy('pos_y','asc')
			->orderBy('pos_x','asc')
			->with('port')
			->get();

		$gracz = Auth::user()->id;

		//Session::put('lower_bond_x', $lower_bond_x);
		//Session::put('lower_bond_y', $lower_bond_y);

		return view('mapa.index',compact('mapy','lower_bond_x','upper_bond_x','lower_bond_y','upper_bond_y','gracz'));
	}

	public function left() {
		$lower_bond_x = Session::get('lower_bond_x',0);
		$lower_bond_y = Session::get('lower_bond_y',0);
		
		$lower_bond_x -= 1;

		Session::put('lower_bond_x', $lower_bond_x);
		Session::put('lower_bond_y', $lower_bond_y);
		
		return Redirect::to('/mapa');
		//return Redirect::to('/mapa')->with('lower_bond_x', $lower_bond_x)->with('lower_bond_y', $lower_bond_y);
	}

	public function right() {
		$lower_bond_x = Session::get('lower_bond_x',0);
		$lower_bond_y = Session::get('lower_bond_y',0);

		$lower_bond_x += 1;

		Session::put('lower_bond_x', $lower_bond_x);
		Session::put('lower_bond_y', $lower_bond_y);
		
		return Redirect::to('/mapa');
		//return Redirect::to('/mapa')->with('lower_bond_x', $lower_bond_x)->with('lower_bond_y', $lower_bond_y);
	}

	public function up() {
		$lower_bond_x = Session::get('lower_bond_x',0);
		$lower_bond_y = Session::get('lower_bond_y',0);
		
		$lower_bond_y -= 1;

		Session::put('lower_bond_x', $lower_bond_x);
		Session::put('lower_bond_y', $lower_bond_y);
		
		return Redirect::to('/mapa');
		//return Redirect::to('/mapa')->with('lower_bond_x', $lower_bond_x)->with('lower_bond_y', $lower_bond_y);
	}

	public function down() {
		$lower_bond_x = Session::get('lower_bond_x',0);
		$lower_bond_y = Session::get('lower_bond_y',0);
		
		$lower_bond_y += 1;

		Session::put('lower_bond_x', $lower_bond_x);
		Session::put('lower_bond_y', $lower_bond_y);
		
		return Redirect::to('/mapa');
		//return Redirect::to('/mapa')->with('lower_bond_x', $lower_bond_x)->with('lower_bond_y', $lower_bond_y);
	}

	public function center() {
		if(Session::has('id_akt')) {
			$id_portu = Session::get('id_akt');
		} else {
			$id = Auth::user()->id;
			$id_portu = Port::where('gracz_id','=',$id)->first()->id;

			Session::put('id_akt',$id_portu);
		}
		$port = Port::where('id','=',$id_portu)->with('mapa')->first();

		$lower_bond_x = $port -> mapa -> pos_x - 3;
		$lower_bond_y = $port -> mapa -> pos_y - 3;

		Session::put('lower_bond_x', $lower_bond_x);
		Session::put('lower_bond_y', $lower_bond_y);

		return Redirect::to('/mapa');
	}
}
