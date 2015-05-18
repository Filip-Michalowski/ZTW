<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
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
		
		DB::table('port_surowce')->delete();
		DB::table('port_budynki')->delete();
		DB::table('budynek_koszty')->delete();
		DB::table('budynek_surowce')->delete();
		DB::table('budynki')->delete();
		DB::table('surowce')->delete();
		DB::table('jednostki')->delete();
		DB::table('mapy')->delete();
		DB::table('porty')->delete();
		DB::table('users')->delete();

		// $this->call('UserTableSeeder');
		$uzytkownik = array(
            ['id' => 1, 'name' => 'user', 'email' => 'user@user.com', 'password' => '$2y$10$Srva1Vlwgf9Rjsb7ndcSHuVmpFOQbSNv6WLhuCXNPUK9kO6Xn8Jsa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['id' => 2, 'name' => 'opponent', 'email' => 'opponent@user.com', 'password' => '$2y$10$Srva1Vlwgf9Rjsb7ndcSHuVmpFOQbSNv6WLhuCXNPUK9kO6Xn8Jsa', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
        );

        $port = array(
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
			['id' => 1, 'nazwa' => 'Chuderlak', 'koszt' => 50],
			['id' => 2, 'nazwa' => 'Bukanier', 'koszt' => 120],
			['id' => 3, 'nazwa' => 'Treser papug', 'koszt' => 200]
		);

		$surowce = array(
			['id' => 1, 'typ' => 'bling'],
			['id' => 2, 'typ' => 'grog'],
			['id' => 3, 'typ' => 'papugi'],
			['id' => 4, 'typ' => 'pustaki'],
		);

		$budynki = array(
			['id' => 1, 'nazwa' => 'Kantyna', 'koszt' => '20'],
			['id' => 2, 'nazwa' => 'Papugarnia', 'koszt' => '40'],
		);

		$budynek_surowce = array(
			['budynek_id' => 1, 'surowiec_id' => 1, 'przyrost' => 2],
			['budynek_id' => 1, 'surowiec_id' => 2, 'przyrost' => 1],
			['budynek_id' => 2, 'surowiec_id' => 3, 'przyrost' => 1],
		);

		$budynek_koszty = array(
			['budynek_id' => 1, 'surowiec_id' => 1, 'koszt' => 10],
			['budynek_id' => 2, 'surowiec_id' => 1, 'koszt' => 20],
			['budynek_id' => 2, 'surowiec_id' => 2, 'koszt' => 10],
		);

		$port_budynki = array(
			['port_id' => 1, 'budynek_id' => 1, 'poziom' => 0],
			['port_id' => 1, 'budynek_id' => 2, 'poziom' => 0],
			['port_id' => 2, 'budynek_id' => 1, 'poziom' => 0],
			['port_id' => 2, 'budynek_id' => 2, 'poziom' => 0],
		);

		$port_surowce = array(
			['port_id' => 1, 'surowiec_id' => 1, 'ilosc' => 100, 'rate' => 1,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		 	['port_id' => 1, 'surowiec_id' => 2, 'ilosc' => 0, 'rate' => 0,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		 	['port_id' => 1, 'surowiec_id' => 3, 'ilosc' => 0, 'rate' => 0,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
			['port_id' => 2, 'surowiec_id' => 1, 'ilosc' => 100, 'rate' => 1,
			 'created_at' => Carbon::now(),'updated_at' => Carbon::now(),],
		 	['port_id' => 2, 'surowiec_id' => 2, 'ilosc' => 0, 'rate' => 0,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		 	['port_id' => 2, 'surowiec_id' => 3, 'ilosc' => 0, 'rate' => 0,
			 'created_at' => Carbon::now(), 'updated_at' => Carbon::now(),],
		);
		
		DB::table('users')->insert($uzytkownik);
		DB::table('porty')->insert($port);
		DB::table('mapy')->insert($mapy);
		DB::table('jednostki')->insert($jednostki);
		DB::table('surowce')->insert($surowce);
		DB::table('budynki')->insert($budynki);
		DB::table('budynek_surowce')->insert($budynek_surowce);
		DB::table('budynek_koszty')->insert($budynek_koszty);
		DB::table('port_budynki')->insert($port_budynki);
		DB::table('port_surowce')->insert($port_surowce);
	}

}
