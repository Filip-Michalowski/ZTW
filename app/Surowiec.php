<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class Surowiec extends Model {

	protected $table = 'surowce';

	/**
	 * Dodaje lub zabiera surowce z portu (grabieże będą obsługiwane na zewnątrz)
 	 * 
	 *
	 * @param  int  $port_id, $surowiec_id, $zmiana
	 * @return sukces
	 */
	public static function inout($port_id, $surowiec_id, $zmiana)
	{
		$port_surowiec = Port_Surowce::where('port_id','=',$port_id)
			->where('surowiec_id','=',$surowiec_id)
			->first();

		if($port_surowiec == null) {
			return false;
		} else {
			$nowa_ilosc = $port_surowiec->ilosc + $zmiana;

			$updated_at = time();

			if($nowa_ilosc < 0) {
				if($port_surowiec->rate > 0) {
					$nowa_ilosc = $nowa_ilosc
			 		+ ( $updated_at - strtotime($port_surowiec->updated_at) )
				 	/ 60
		 		 	* $port_surowiec->rate;

		 		 	if($nowa_ilosc < 0) {
						return false;
		 		 	} else {
		 		 		Port_Surowce::where('port_id','=',$port_surowiec->port_id)
							->where('surowiec_id','=',$port_surowiec->surowiec_id)
							->update([
								'ilosc' => $nowa_ilosc,
								'updated_at' => date('Y-m-d H:i:s',$updated_at)
						]);
		 		 	}
				}
			} else if($nowa_ilosc > $port_surowiec->magazyn) {
				$nowa_ilosc = $port_surowiec->magazyn;

				Port_Surowce::where('port_id','=',$port_surowiec->port_id)
					->where('surowiec_id','=',$port_surowiec->surowiec_id)
					->update([
						'ilosc' => $nowa_ilosc,
						'updated_at' => date('Y-m-d H:i:s',$updated_at)
				]);
			} else {
				Port_Surowce::where('port_id','=',$port_surowiec->port_id)
					->where('surowiec_id','=',$port_surowiec->surowiec_id)
					->update([
						'ilosc' => $nowa_ilosc,
						'updated_at' => $port_surowiec->updated_at
				]);
			}

			return true;
		}
	}

	/**
	 * Odświeża wszystkie surowce w porcie
	 *
	 * @param  int  $port_id
	 * @return Response
	 */
	public static function refresh($port_id)
	{
		//$port_id = Session::get('id_akt'); - zostawiam możliwość "zdalnego" update'a

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
			$tally_rate = 0;
			$tally_mag = 200;
			foreach ($port_budynki as $pb) {
				//echo '-- '.$pb->budynek_id.'<br/>';
				if($pb->surowiec_id == $ps->surowiec_id) {
					//echo 'surowiec =- '.$pb->surowiec_id.'<br/>';
					//echo 'rate =- '.$pb->rate.'<br/>';
					$tally_rate += $pb->rate;
					$tally_mag += $pb->magazyn;
				}
			}
			//Obliczenie nowego zapasu
			//echo '$ps->ilosc='.$ps->ilosc.'<br/>';
			//echo '( $updated_at - strtotime($ps->updated_at) )='.( $updated_at - strtotime($ps->updated_at) ).'<br/>';
			//echo '(( $updated_at - strtotime($ps->updated_at) )/60)='.(( $updated_at - strtotime($ps->updated_at) )/60).'<br/>';
			//echo '$tally_rate='.$tally_rate.'<br/>';
			$ilosc = $ps->ilosc
		 		+ ( $updated_at - strtotime($ps->updated_at) )
			 	/ 60
	 		 	* $tally_rate;

	 		if($ilosc > $tally_mag) {
	 			$ilosc = $tally_mag;
	 		}
			//echo 'surowiec #'.$ps->surowiec_id.'='.$ilosc.'<br/>';

			Port_Surowce::where('port_id','=',$ps->port_id)
				->where('surowiec_id','=',$ps->surowiec_id)
				->update([
					'ilosc' => $ilosc,
					'rate' => $tally_rate,
					'magazyn' => $tally_mag,
					'updated_at' => date('Y-m-d H:i:s',$updated_at)
			]);
		}
	}
}
