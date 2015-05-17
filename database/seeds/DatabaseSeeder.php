<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Model::unguard();
		
		DB::table('users')->delete();

		// $this->call('UserTableSeeder');
		$uzytkownik = array(
            ['id' => 1, 'name' => 'user', 'email' => 'user@user.com', 'password' => '$2y$10$Srva1Vlwgf9Rjsb7ndcSHuVmpFOQbSNv6WLhuCXNPUK9kO6Xn8Jsa', 'created_at' => new DateTime, 'updated_at' => new DateTime],
            ['id' => 2, 'name' => 'opponent', 'email' => 'opponent@user.com', 'password' => '$2y$10$Srva1Vlwgf9Rjsb7ndcSHuVmpFOQbSNv6WLhuCXNPUK9kO6Xn8Jsa', 'created_at' => new DateTime, 'updated_at' => new DateTime]
        );
        $port = array(
        	['id' => 1, 'nazwa' => 'Helheim', 'gracz_id' => 1],
        	['id' => 2, 'nazwa' => 'Valhalla', 'gracz_id' => 2]
    	);
    	/*$mapy = array (
    		['id' => 1, 'pos_x' => 2, 'pos_y' => 2, 'port_id' => 1],
    		['id' => 2, 'pos_x' => 8, 'pos_y' => 4, 'port_id' => 2],
    		['id' => 3, 'pos_x' => 5, 'pos_y' => 3, 'port_id' => null]
		);*/
		$mapy = array();

		for($x = 0; $x < 50; $x++) {
			for($y = 0; $y < 50; $y++) {
				$pole = array('id' => ($x * 50 + $y + 1), 'pos_x' => $x, 'pos_y' => $y);
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
					if($szansa <= 15) {
						$pole['typ'] = 1;
					} else {
						$pole['typ'] = 0;
					}
					$pole['port_id'] = null;
				}
				$mapy[] = $pole;
			}
		}
		
		DB::table('users')->insert($uzytkownik);
		DB::table('porty')->insert($port);				
		DB::table('mapy')->insert($mapy);

	}

}
