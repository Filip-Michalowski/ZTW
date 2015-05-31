<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Surowiec;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		DB::table('atak_jednostki')->delete();
		DB::table('ataki')->delete();
		DB::table('port_surowce')->delete();
		DB::table('port_budynki')->delete();
		DB::table('budynek_koszty')->delete();
		DB::table('budynek_surowce')->delete();
		DB::table('budynki')->delete();
		DB::table('surowce')->delete();
		DB::table('jednostka_koszty')->delete();
		DB::table('jednostki')->delete();
		DB::table('mapy')->delete();
		DB::table('porty')->delete();
		DB::table('users')->delete();

		// $this->call('UserTableSeeder');
		$uzytkownik = array(
            ['id' => 1, 'name' => 'user', 'email' => 'user@user.com', 'password' => '$2y$10$Srva1Vlwgf9Rjsb7ndcSHuVmpFOQbSNv6WLhuCXNPUK9kO6Xn8Jsa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'opponent', 'email' => 'opponent@user.com', 'password' => '$2y$10$Srva1Vlwgf9Rjsb7ndcSHuVmpFOQbSNv6WLhuCXNPUK9kO6Xn8Jsa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $porty = array(
        	['id' => 1, 'nazwa' => 'Helheim', 'gracz_id' => 1],
        	['id' => 2, 'nazwa' => 'Valhalla', 'gracz_id' => 2]
    	);
    	
    	$mapy = array();

    	/**
		*Tworzy mapę o rozmiarach 50x50 kratek,
		*z 3 znanymi wyspami
		*i z 5.5% szansą na wystąpienie wyspy
    	*/
    	//Klucz główny trzęba będzie zamienić na (pos_x,pos_y)
		for($x = 0; $x < 50; $x++) {
			for($y = 0; $y < 50; $y++) {
				$pole = array('pos_x' => $x, 'pos_y' => $y);
				$pole['id'] = 50*$y + $x;
				//echo( $pole['id']." " );
				if($x == 2 && $y == 2) {
					//echo "2,2<br/>";
					//stała - wyspa uses@user.com
					$pole['port_id'] = 1;
					$pole['typ'] = 1;
				} else if($x == 8 && $y == 4) {
					//echo "8,4<br/>";
					//stała - wyspa opponent@user.com
					$pole['port_id'] = 2;
					$pole['typ'] = 1;
				} else if($x == 5 && $y == 3) {
					//echo "5,3<br/>";
					//stała - wyspa pusta pomiędzy dwoma wrogami
					$pole['port_id'] = null;
					$pole['typ'] = 1;
				} else {
					//echo "rand<br/>";
					$szansa = rand(1,1000);
					if($szansa <= 55) {
						$pole['typ'] = 1;
					} else {
						$pole['typ'] = 0;
					}
					$pole['port_id'] = null;
				}
				$mapy[] = $pole;
			}
		}

		$jednostki = array(
			['id' => 1, 'nazwa' => 'Chuderlak', 'plecak' => 3, 'atak' => 10, 'obrona' => 10],
			['id' => 2, 'nazwa' => 'Bukanier', 'plecak' => 1, 'atak' => 13, 'obrona' => 20],
			['id' => 3, 'nazwa' => 'Treser papug', 'plecak' => 1, 'atak' => 40, 'obrona' => 4],
			['id' => 4, 'nazwa' => 'Cyber-Pirat', 'plecak' => 10, 'atak' => 100, 'obrona' => 100],
			['id' => 100, 'nazwa' => 'Major-Generał', 'plecak' => 0, 'atak' => 1, 'obrona' => 11],
		);

		$surowce = array(
			['id' => 1, 'typ' => 'bling'],
			['id' => 2, 'typ' => 'grog'],
			['id' => 3, 'typ' => 'papugi'],
			['id' => 4, 'typ' => 'pustaki'],
		);

		$jednostka_koszty = array(
			['jednostka_id' => 1, 'surowiec_id' => 1, 'koszt' => 50],
			['jednostka_id' => 1, 'surowiec_id' => 2, 'koszt' => 20],
			['jednostka_id' => 2, 'surowiec_id' => 1, 'koszt' => 40],
			['jednostka_id' => 2, 'surowiec_id' => 2, 'koszt' => 20],
			['jednostka_id' => 2, 'surowiec_id' => 4, 'koszt' => 10],
			['jednostka_id' => 3, 'surowiec_id' => 1, 'koszt' => 100],
			['jednostka_id' => 3, 'surowiec_id' => 3, 'koszt' => 15],
			['jednostka_id' => 4, 'surowiec_id' => 1, 'koszt' => 50],
			['jednostka_id' => 4, 'surowiec_id' => 2, 'koszt' => 50],
			['jednostka_id' => 4, 'surowiec_id' => 3, 'koszt' => 50],
			['jednostka_id' => 4, 'surowiec_id' => 4, 'koszt' => 50],
			['jednostka_id' => 100, 'surowiec_id' => 1, 'koszt' => 2000],
			['jednostka_id' => 100, 'surowiec_id' => 2, 'koszt' => 1000],
			['jednostka_id' => 100, 'surowiec_id' => 3, 'koszt' => 500],
			['jednostka_id' => 100, 'surowiec_id' => 4, 'koszt' => 300],
		);

		$port_jednostki = array();

		foreach($porty as $por) {
			foreach($jednostki as $jed) {
				if($jed['id'] < 3) {
					//////////////////////////////////////////////////////////////////////Ilość 
					$port_jednostki[] = ['port_id' => $por['id'],
					 'jednostka_id' => $jed['id'],
					  'ilosc' => 50, 'produkowana' => true];
				} else if($jed['id'] == 100) {
					$port_jednostki[] = ['port_id' => $por['id'],
					 'jednostka_id' => $jed['id'],
					  'ilosc' => 2, 'produkowana' => true];
				} else {
					$port_jednostki[] = ['port_id' => $por['id'],
					 'jednostka_id' => $jed['id'],
					  'ilosc' => 0, 'produkowana' => true];
				}
			}
		}

		//['port_id' => 1, 'jednostka_id' => 1, 'ilosc' => 0, 'produkowana' => true]

		$budynki = array(
			['id' => 1, 'nazwa' => 'Kantyna', 'koszt' => '20'],
			['id' => 2, 'nazwa' => 'Papugarnia', 'koszt' => '40'],
			['id' => 3, 'nazwa' => 'Magazyn', 'koszt' => '40'],
		);

		$budynek_surowce = array(
			['budynek_id' => 1, 'surowiec_id' => 1, 'rate' => 0.2],
			['budynek_id' => 1, 'surowiec_id' => 2, 'rate' => 0.1],
			['budynek_id' => 2, 'surowiec_id' => 3, 'rate' => 0.1],
		);

		$budynek_surowce_mag = array(
			['budynek_id' => 3, 'surowiec_id' => 1, 'magazyn' => 200],
			['budynek_id' => 3, 'surowiec_id' => 2, 'magazyn' => 200],
			['budynek_id' => 3, 'surowiec_id' => 3, 'magazyn' => 200],
			['budynek_id' => 3, 'surowiec_id' => 4, 'magazyn' => 200],
		);

		$budynek_koszty = array(
			['budynek_id' => 1, 'surowiec_id' => 1, 'koszt' => 10],
			['budynek_id' => 2, 'surowiec_id' => 1, 'koszt' => 20],
			['budynek_id' => 2, 'surowiec_id' => 2, 'koszt' => 10],
			['budynek_id' => 3, 'surowiec_id' => 1, 'koszt' => 150],
			['budynek_id' => 3, 'surowiec_id' => 2, 'koszt' => 150],
			['budynek_id' => 3, 'surowiec_id' => 3, 'koszt' => 150],
		);

		$port_budynki = array(
			['port_id' => 1, 'budynek_id' => 1, 'poziom' => 3],
			['port_id' => 1, 'budynek_id' => 2, 'poziom' => 4],
			['port_id' => 1, 'budynek_id' => 3, 'poziom' => 10],
			['port_id' => 2, 'budynek_id' => 1, 'poziom' => 0],
			['port_id' => 2, 'budynek_id' => 2, 'poziom' => 0],
			['port_id' => 2, 'budynek_id' => 3, 'poziom' => 0],
		);

		$port_surowce = array(
			['port_id' => 1, 'surowiec_id' => 1, 'ilosc' => 800, 'rate' => 1,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		 	['port_id' => 1, 'surowiec_id' => 2, 'ilosc' => 100, 'rate' => 0,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		 	['port_id' => 1, 'surowiec_id' => 3, 'ilosc' => 8000, 'rate' => 0,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
			['port_id' => 1, 'surowiec_id' => 4, 'ilosc' => 0, 'rate' => 0,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
			['port_id' => 2, 'surowiec_id' => 1, 'ilosc' => 100, 'rate' => 1,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(),'updated_at' => Carbon::now(),],
		 	['port_id' => 2, 'surowiec_id' => 2, 'ilosc' => 0, 'rate' => 0,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		 	['port_id' => 2, 'surowiec_id' => 3, 'ilosc' => 0, 'rate' => 0,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
			['port_id' => 2, 'surowiec_id' => 4, 'ilosc' => 0, 'rate' => 0,
			 'magazyn' => 200,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		);

		$ataki = array(
			/* Atak wygrywający z Valhalli na Helheim */
			['id' => 1, 'atakujacy_gracz_id' => 2, 'atakujacy_port_id' => 2,
			 'broniacy_gracz_id' => 1, 'broniacy_port_id' => 1,
			 'dataBojki' => Carbon::now()->addMinutes(1),
			 'dataPowrotu' => Carbon::now()->addMinutes(2),
			 'status' => 0,
			 'cel_x' => 2,
			 'cel_y' => 2],
			/* Atak przegrywający z Helheimu na Valhalle */
			['id' => 2, 'atakujacy_gracz_id' => 1, 'atakujacy_port_id' => 1,
			 'broniacy_gracz_id' => 2, 'broniacy_port_id' => 2,
			 'dataBojki' => Carbon::now()->addMinutes(2),
			 'dataPowrotu' => Carbon::now()->addMinutes(3),
			 'status' => 0,
			 'cel_x' => 8,
			 'cel_y' => 4],
			/* Pokojowy przemarsz z Helheimu do Helheimu */
			['id' => 3, 'atakujacy_gracz_id' => 1, 'atakujacy_port_id' => 1,
			 'broniacy_gracz_id' => 1, 'broniacy_port_id' => 1,
			 'dataBojki' => Carbon::now()->addMinutes(4),
			 'dataPowrotu' => Carbon::now()->addMinutes(5),
			 'status' => 0,
			 'cel_x' => 2,
			 'cel_y' => 2],
			
		);

		$atak_jednostki = array(
			/* Atak wygrywający z Valhalli na Helheim */
			['atak_id' => 1, 'jednostka_id' => 1, 'ilosc_wyjscie' => 300],
			['atak_id' => 1, 'jednostka_id' => 3, 'ilosc_wyjscie' => 100],
			/* Atak przegrywający z Helheimu na Valhalle */
			['atak_id' => 2, 'jednostka_id' => 1, 'ilosc_wyjscie' => 50],
			/* Pokojowy przemarsz z Helheimu do Helheimu */
			['atak_id' => 3, 'jednostka_id' => 1, 'ilosc_wyjscie' => 1000],
			['atak_id' => 3, 'jednostka_id' => 4, 'ilosc_wyjscie' => 1],
			
		);
		
		DB::table('users')->insert($uzytkownik);
		DB::table('porty')->insert($porty);
		DB::table('mapy')->insert($mapy);
		DB::table('jednostki')->insert($jednostki);
		DB::table('surowce')->insert($surowce);
		DB::table('jednostka_koszty')->insert($jednostka_koszty);
		DB::table('port_jednostki')->insert($port_jednostki);
		DB::table('budynki')->insert($budynki);
		DB::table('budynek_surowce')->insert($budynek_surowce);
		DB::table('budynek_surowce')->insert($budynek_surowce_mag);
		DB::table('budynek_koszty')->insert($budynek_koszty);
		DB::table('port_budynki')->insert($port_budynki);
		DB::table('port_surowce')->insert($port_surowce);
		DB::table('ataki')->insert($ataki);
		DB::table('atak_jednostki')->insert($atak_jednostki);

		$statement = "ALTER TABLE jednostki AUTO_INCREMENT = 5;";
		DB::unprepared($statement);

		foreach($porty as $p) {
			Surowiec::refresh($p['id']);
		}
	}

}
