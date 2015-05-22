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
		$rutabaga = 0;
		
		while ( ! $stop ) {
			$rutabaga++;
			sleep(1); // Sleep for one second
			
			//Dodanie nowych ataków do kolejki
			$sql = "SELECT * FROM ataki WHERE status = 0";
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result)) {
				while($row=mysql_fetch_assoc($result)){
					$sql = "UPDATE ataki SET status = 1 WHERE id =".$row['id'];
					/*********************************************************************************************************************///mysql_query($sql);
					
					$row['status']=1;
					
					$queue->insert($row,$row['dataBojki']);
					echo $row['dataBojki'];
					echo '<br/>';
					echo "id: ".$row['id'];
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
			$zrobione = false;
			
			/*if( strtotime(queue->top()) <= $czas ) {
				$zrobione = false;*/
				
			while(! $zrobione && ! $queue->isEmpty()) {
				$czubek = $queue->top();
			
				if($czubek['status'] == 1 && strtotime($czubek['dataBojki']) <= $czas) {
					//Atak, kolonizacja i relokacja
					$atak = $queue->extract();
					
					$sql = "SELECT port_id FROM mapy WHERE pos_x=".$atak['cel_x']." AND pos_y=".$atak['cel_y'];
					$result = mysql_query($sql);
					$cel = mysql_fetch_assoc($result);
					
					if($cel == null) {
						//TODO - kolonizacja
						//Bezludna wyspa (bez portu)
					} else {
						$sql = "SELECT * FROM porty WHERE id=".$cel['port_id'];
						$result = mysql_query($sql);
						$cel_port = mysql_fetch_assoc($result);
						
						$sql = "SELECT * FROM port_jednostki AS sj JOIN jednostki AS j
							ON (sj.jednostka_id = j.id)
							WHERE port_id=".$cel['port_id']." ORDER BY jednostka_id ASC";
						$result = mysql_query($sql);
						$cel_jednostki = mysql_fetch_assoc($result);
						
						//Zak³adamy, ¿e istnieje co najmniej 1 jednostka w ataku
						//Istnienie ataku bez jednostek jest b³êdem!
						$sql = "SELECT *
							FROM atak_jednostki AS aj JOIN jednostki AS j
							ON (aj.jednostka_id = j.id)
							WHERE atak_id=".$atak['id']." 
							ORDER BY jednostka_id ASC";
						$result = mysql_query($sql);
						$atak_jednostki = mysql_fetch_assoc($result);
						
						if($cel_port['gracz_id'] == $atak['atakujacy_gracz_id']) {
							//Relokacja
							//W³asny (sprzymierzony) port
														
							//Pocz¹tek INSERT INTO ... ON DUPLICATE KEY UPDATE ...
							//UWAGA - zwiêksza wartoœæ AUTO_INCREMENT, zatem NIE U¯YWAÆ TEGO W TABELACH Z AUTO_INCREMENT!!!
							$sql = "INSERT INTO port_jednostki (port_id, jednostka_id, ilosc)
								VALUES ";
							
							$first = true;
							
							foreach($atak_jednostki as $aj) {								
								$i = count($cel_jednostki) - 1;
								$brak = true;
								
								while($brak && $i > 0) {
									echo '<br/>$i: '.$i;
									if($cel_jednostki[$i]['jednostka_id'] == $aj['jednostka_id']) {
										$aj['ilosc'] += $cel_jednostki[$i]['ilosc'];
										$brak = false;
									}
									else {
										$i--;
									}
								}
								
								if($first) {
									$first = false;
								} else {
									$sql .= ", ";
								}
								
								$sql .= "(".$cel['port_id'].", ".$aj['jednostka_id'].", ".$aj['ilosc'].")";
							}
							
							//UPDATE jednostek w porcie 
							$sql .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc);";
							$result = mysql_query($sql);
						} else {
							//Atak
							//Cudzy (wrogi) port
							
							$cel_sila = 0;
							$atak_sila = 0;
							
							foreach($cel_jednostki as $cj) {
								$cel_sila += $cj['obrona'];
							}
							
							foreach($atak_jednostki as $aj) {
								$atak_sila += $aj['atak'];
							}
							
							//U¿ywamy Travianowej formu³y strat (na przysz³oœæ a'la GalCiv?)
							//950 vs 1000 oraz 1050 vs 1000 generuje diametrialne ró¿ne straty dla 1000 (93% dla pierwsze, 6% dla drugiej)
							//Prawdopodobnie jest tak dobrana, by bliskie starcia by³y nieprzewidywalne
							//Dla zwyciêzców (prz_sila/zw_sila)^1.5
							//i przegranych 1 - (prz_sila/zw_sila)^1.5
							//Ustalmy, ¿e 90+% po obu stronach dla remisu
							if($cel_sila < $atak_sila) {
								//Atakuj¹cy wygrywa i kradnie surowce
								$atak_straty = pow(($cel_sila/$atak_sila), 1.5);
								$cel_straty = 1.0 - $atak_straty;
								
								//Wyœle wszystkie zapytania naraz
								$sql_bulk = "START TRANSACTION;";
								
								foreach($cel_jednostki as $cj) {
									$cj['ilosc'] -= round($cel_straty * $cj['ilosc']);
									
									$sql_bulk .= "UPDATE port_jednostki SET ilosc = ".$cj['ilosc']
										." WHERE port_id=".$cel['port_id']." AND jednostka_id=".$cj['jednostka_id'];
								}
								
								
								//Straty
								//Grabie¿
								
								$sql_bulk .= "COMMIT;";
								$result_bulk = mysql_query($sql_bulk);
								if($result == false)
									echo "Transakcja siê nie powiod³a.";
								
							} else if($cel_sila > $atak_sila) {
								//Atakuj¹cy przegrywa i wraca z niczym
								$cel_straty = pow(($atak_sila/$cel_sila), 1.5);
								$atak_straty = 1.0 - $cel_straty;
							} else {
								//95% strat po obu stronach
							}
							
							
							
						}
					}
					
					//Walka
					
					//Grabie¿
				} else if($czubek['status'] == 2 && strtotime($czubek['dataPowrotu']) <= $czas) {
					//Powrót
				} else {
					$zrobione = true;
				}
			}
				
				
				//WA¯NE! - Wstawienie czêœciowych z powrotem
			
			/***/if( $rutabaga >= 1 ) {
				/********/$stop = true;
				/********/echo '<br/>Czas dzia³ania: '.(time() - $czas);
			}
		}
	}
	
	mysql_close($con);
	exit();
?>