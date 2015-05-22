<?php
	$host="127.0.0.1"; //replace with database hostname 
	$username="root"; //replace with database username 
	$password=""; //replace with database password 
	$db_name="laravel"; //replace with database name 

	$con=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	ignore_user_abort(true); 
	set_time_limit(0);
	
	demon();
	
	class KolejkaPriorytetowa extends SplPriorityQueue {
		public function compare($priority1, $priority2) 
		{
			if ($priority1 === $priority2)
				return 0;
			
			//Daty wczeœniejsze maj¹ ni¿szy priorytet
			return $priority1 > $priority2 ? -1 : 1;
		}
	}
	
	function beatEmUp() {
		
	}
	
	function plunder() {
		
	}
	
	function demon() {
		//Kolejka priorytetowa
		//Daty wczeœniejsze maj¹ ni¿szy priorytet
		//Biblioteka Spl jest dostêpna dla php >= 5.3, ale nie ma to znaczenia, bo laravel wymaga >= 5.4
		$queue = new KolejkaPriorytetowa();
		
		//Warunek stopu: na przysz³oœæ, do implementacji periodycznego odœwie¿ania.
		$stop = false;
		
		//Licznik rozpoczêtych pêtli, na przysz³oœæ:
		//0 - pierwszy rozruch, trzeba wczytaæ niedokoñczone
		//3600/7200/86.400 - d³ugo chodzi? Refresh.
		$i = 0;
		
		while ( ! $stop ) {
			$i++;
			sleep(1); // Sleep for one second
			
			//Dodanie nowych ataków do kolejki
			$sql = "SELECT * FROM ataki WHERE status = 0";
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result)) {
				while($row=mysql_fetch_assoc($result)){
					$queue->insert($row,$row['dataBojki']);
					echo $row['dataBojki'];
					echo '<br/>';
					echo "id".$row['id'];
					echo '<br/>';
				}
			}
			
			echo '<br/>Podgl¹d kolejki:<br/>';
			
			/*
			//Debug
			while(! $queue->isEmpty()) {
				$row = $queue->extract();
				echo $row['dataBojki'].' co jest '.(strtotime($row['dataBojki']) > time() ? 'wiêksze' : 'mniejsze').' od obecnej chwili';
				echo '<br/>';
				echo "id".$row['id'];
				echo '<br/>';
			}*/
			
			$czas = time();
			echo $czas.'<br/>';
			
			//Czêœæ w³aœciwa
			if( strtotime(queue->top()) <= $czas ) {
				$zrobione = false;
				
				while(! $zrobione) {
					$atak = 
				}
				
				
				//Przelecenie
			
				//WA¯NE! - Wstawienie czêœciowych z powrotem
				
			}
			
			/***/if( $i >= 1 ) {
				/********/$stop = true;
			}
		}
	}
	
	mysql_close($con);
	exit();
?>