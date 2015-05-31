<?php
/*
OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE 
OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE 
OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE 
OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE 
OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE 
OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE 
OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE 
*/
	$host="127.0.0.1"; //replace with database hostname 
	$username="root"; //replace with database username 
	$password=""; //replace with database password 
	$db_name="laravel"; //replace with database name 

	$con=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	for($i = 0; $i<6; $i++) {
		echo 'OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE OBSOLETE<br/>';
	}
	
	/*
		WA¯NE!
		Tymczasowo ingore_user_abort jest ustawione na 'false', a time_limit na 0.
		Podczas implementacji czêœci serwerowej trzeba bêdzie zmodyfikowaæ te wartoœci,
		gdy¿ bêd¹ one obs³ugiwane CRONem.
	*/
	//ignore_user_abort(true);
	ignore_user_abort(false);
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
		$rutabaga = 3;
		
		$sql = "SELECT * FROM ataki WHERE status = 1 OR status = 2";
		$result = mysql_query($sql);
		
		if(mysql_num_rows($result)) {
			while($row=mysql_fetch_assoc($result)){
				if($row['status']==1)
					$queue->insert($row,$row['dataBojki']);
				else
					$queue->insert($row,$row['dataPowrotu']);
			}
		}
		
		while ( ! $stop ) {
			$rutabaga--;
			sleep(1); // Sleep for one second
			
			//Dodanie nowych ataków do kolejki
			$sql = "SELECT * FROM ataki WHERE status = 0";
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result)) {
				while($row=mysql_fetch_assoc($result)){
					$sql = "UPDATE ataki SET status = 1 WHERE id =".$row['id'];
					mysql_query($sql);
					
					$row['status']=1;
					
					$queue->insert($row,$row['dataBojki']);
					echo 'data bójki: '.$row['dataBojki'];
					echo '<br/>';
					echo "id: ".$row['id'];
					echo '<br/>';
					
				}
			}
			
			$czas = time();
			echo $czas.'<br/>';
			
			//Czêœæ w³aœciwa
			$zrobione = false;
			
			while(! $zrobione && ! $queue->isEmpty()) {
				$czubek = $queue->top();
				if($czubek != null) {
					echo '<br/><br/> CZUBEK: status='.$czubek['status'].', dataBojki: '.$czubek['dataBojki']
						.', dataPowrotu'.$czubek['dataPowrotu'].'<br/>';
				} else {
					echo '<br/>$czubek jest null';
				}
			
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
						echo '<br/>'.$sql;
						$result = mysql_query($sql);
						$cel_port = mysql_fetch_assoc($result);
						
						$sql = "SELECT * FROM port_jednostki AS sj JOIN jednostki AS j
							ON (sj.jednostka_id = j.id)
							WHERE port_id=".$cel['port_id']." ORDER BY jednostka_id ASC";
						echo '<br/>'.$sql;
						$result = mysql_query($sql);
						$cel_jednostki = array();
						while($row=mysql_fetch_assoc($result)){
							$cel_jednostki[] = $row;
							echo '<br/>'.$row['jednostka_id'];
						}
						
						echo '<br/>Cel jednostki: '.$cel_jednostki[1]['jednostka_id'];
						$xxlik = 1;
						echo '<br/>Cel jednostki: '.$cel_jednostki[$xxlik]['jednostka_id'];
						
						
						//Zak³adamy, ¿e istnieje co najmniej 1 jednostka w ataku
						//Istnienie ataku bez jednostek jest b³êdem!
						$sql = "SELECT *
							FROM atak_jednostki AS aj JOIN jednostki AS j
							ON (aj.jednostka_id = j.id)
							WHERE atak_id=".$atak['id']." AND czy_obronca = 0
							ORDER BY jednostka_id ASC";
						echo '<br/>'.$sql;
						$result = mysql_query($sql);
						$atak_jednostki = array();
						while($row=mysql_fetch_assoc($result)) {
							$atak_jednostki[] = $row;
						}
						
						if($cel_port['gracz_id'] == $atak['atakujacy_gracz_id']) {
							//Relokacja
							//W³asny (sprzymierzony) port
														
							//Pocz¹tek INSERT INTO ... ON DUPLICATE KEY UPDATE ...
							//UWAGA - zwiêksza wartoœæ AUTO_INCREMENT, zatem NIE U¯YWAÆ TEGO W TABELACH Z AUTO_INCREMENT!!!
							$sql = "INSERT INTO port_jednostki (port_id, jednostka_id, ilosc)
								VALUES ";
							
							$first = true;
							
							foreach($atak_jednostki as $klucz => $aj) {
								$i = count($cel_jednostki) - 1;
								$brak = true;
								
								while($brak && $i >= 0) {
									echo '<br/>$i: '.$i;
									if($cel_jednostki[$i]['jednostka_id'] == $aj['jednostka_id']) {
										$atak_jednostki[$klucz]['ilosc_wyjscie'] += $cel_jednostki[$i]['ilosc'];
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
								
								$sql .= "(".$cel['port_id'].", ".$aj['jednostka_id'].", ".$atak_jednostki[$klucz]['ilosc_wyjscie'].")";
							}
							
							//UPDATE jednostek w porcie 
							$sql .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc);";
							$result = mysql_query($sql);
							
							//Zg³oszenie koñca przetwarzania tego ataku
							$atak['status'] = 3;
							$sql = "UPDATE ataki SET status=3 WHERE id=".$atak['id'];
							mysql_query($sql);
						} else {
							//Atak
							//Cudzy (wrogi) port
							$cel_sila = 0;
							$atak_sila = 0;
							
							foreach($cel_jednostki as $cj) {
								$cel_sila += $cj['ilosc'] * $cj['obrona'];
							}
							
							foreach($atak_jednostki as $aj) {
								$atak_sila += $aj['ilosc_wyjscie'] * $aj['atak'];
							}
							
							//U¿ywamy Travianowej formu³y strat (na przysz³oœæ a'la GalCiv?)
							//950 vs 1000 oraz 1050 vs 1000 generuje diametrialne ró¿ne straty dla 1000 (93% dla pierwsze, 6% dla drugiej)
							//Prawdopodobnie jest tak dobrana, by bliskie starcia by³y nieprzewidywalne
							//Dla zwyciêzców (prz_sila/zw_sila)^1.5
							//i przegranych 1 - (prz_sila/zw_sila)^1.5
							//Ustalmy, ¿e 90+% po obu stronach dla remisu
							
							if($cel_sila < $atak_sila) {
						//Atakuj¹cy wygrywa i kradnie surowce
								$sql = "SELECT * FROM port_surowce WHERE port_id=".$cel['port_id'];
								$result = mysql_query($sql);
								$surowce = array();
								while($row=mysql_fetch_assoc($result)){
									//Odczyt i wyliczenie surowców
									$row['ilosc'] += round(($czas - strtotime($row['updated_at'])) / 60 * $row['rate']);
									$row['ilosc'] = min($row['ilosc'],$row['magazyn']);
									
									$surowce[]=$row;
								}
						
								$atak_straty = pow(($cel_sila/$atak_sila), 1.5);
								echo '<br/> straty ataku: '.$atak_straty;
								$cel_straty = 1.0 - $atak_straty;
								echo '<br/> straty cel: '.$cel_straty;
								
								//Pocz¹tek transakcji
								$sql_transact = "START TRANSACTION; ";
								mysql_query($sql_transact);
								
								//Straty dla portu
								foreach($cel_jednostki as $cj) {
									$sql_transact = "INSERT INTO atak_jednostki (atak_id, jednostka_id, czy_obronca, ilosc_wyjscie, ilosc_powrot)
										VALUES (".$atak['id'].", ".$cj['jednostka_id'].", 1, ".$cj['ilosc'].", ";
								
									$cj['ilosc'] -= round($cel_straty * $cj['ilosc']);
									
									$sql_transact .= $cj['ilosc']."); ";
									mysql_query($sql_transact);
									
									$sql_transact = "UPDATE port_jednostki SET ilosc = ".$cj['ilosc']
										." WHERE port_id=".$cel['port_id']." AND jednostka_id=".$cj['jednostka_id']."; ";
									mysql_query($sql_transact);
								}
								
								//Straty dla atakuj¹cego - AKTUALIZUJESZ ilosc_powrot
								foreach($atak_jednostki as $klucz => $aj) {
									echo '<br/>ilosc_wyjscie '.$aj['ilosc_wyjscie'];
									echo '<br/>round($aj[ilosc_wyjscie] * $atak_straty) '.round($aj['ilosc_wyjscie'] * $atak_straty);
									$ilosc_powrot = $aj['ilosc_wyjscie'] - round($aj['ilosc_wyjscie'] * $atak_straty);
									$atak_jednostki[$klucz]['ilosc_powrot'] = $ilosc_powrot;
									echo '<br/>$ilosc_powrot = '.$ilosc_powrot;
									echo '<br/>$aj[ilosc_powrot] = '.$aj['ilosc_powrot'];
									
									$sql_transact = "UPDATE atak_jednostki SET ilosc_powrot=".$ilosc_powrot." WHERE atak_id=".$aj['atak_id']
										." AND jednostka_id=".$aj['jednostka_id']." AND czy_obronca=0";
									echo "<br/>Aktualizacja wracaj¹cych: ".$sql_transact;
									mysql_query($sql_transact);
								}
								
								/**!***/foreach($atak_jednostki as $aj) {
									echo '<br/>Poza pierwsz¹ pêtl¹: $aj[ilosc_powrot] = '.$aj['ilosc_powrot'];
								}
								
								//Grabie¿ - skomplikowane
								$liczba_surowcow = count($surowce);
								
								$plecaki = array();
								
								$wolne_miejsce = 0;								
								foreach($atak_jednostki as $aj) {
									$wolne_miejsce += $aj['plecak'] * $aj['ilosc_powrot'];
									echo "<br/>Przyrostowo: wolne miejsce: ".$wolne_miejsce." ( aj[plecak] = ".$aj['plecak']
									.", aj[ilosc_powrot] = ".$aj['ilosc_powrot'].") ";
								}
								
								//Pêtla rozk³adania surowców
								while($liczba_surowcow > 0) {
									$pierwotna_liczba = $liczba_surowcow;
									
									
									//Wyliczenie œredniej, do której chcemy d¹¿yæ (zaokr¹glone w dó³, by nie przekroczyæ)
									$srednia = floor($wolne_miejsce / $liczba_surowcow);
									//Wyliczenie ( ca³oœæ = [[--srednia--][--srednia--]...[--srednia--][skrawek]] )
									$skrawek = $wolne_miejsce - $liczba_surowcow * $srednia;
																		
									//Jeœli surowców jest mniej ni¿ w œredniej, bierz wszystkie, zajmij nimi dostêpne miejsce,
									//	i zmniejsz liczbê surowców, z których mo¿emy próbowaæ wzi¹æ ca³¹ œredni¹
									foreach($surowce as $klucz => $sur) {
										$sur_id = $sur['surowiec_id'];
										if(!isset($plecaki[$sur_id])) {
											if($sur['ilosc'] < $srednia) {
												$wolne_miejsce -= $sur['ilosc'];
												$plecaki[$sur_id]['ilosc'] = $sur['ilosc'];
												$plecaki[$sur_id]['surowiec_id'] = $sur_id;												
												$liczba_surowcow--;
												
												//Aktualizacja wartoœci dla tych, które ju¿ nie bêd¹ zmieniane
												$surowce[$klucz]['ilosc'] = 0;
											}
										}
									}
									
									//Jeœli w danym przejœciu wszystkie sk³ady surowców by³y wystarczaj¹co du¿e,
									//	by móc z nich wzi¹æ ca³¹ œredni¹, nape³nij nimi plecak
									if($liczba_surowcow == $pierwotna_liczba) {
										foreach($surowce as $klucz => $sur) {
											$sur_id = $sur['surowiec_id'];
											if(!isset($plecaki[$sur_id])) {
												if($sur['ilosc'] >= $srednia + $skrawek) {
													$skrawek = 0;
													$plecaki[$sur_id]['ilosc'] = $srednia + $skrawek;
													$plecaki[$sur_id]['surowiec_id'] = $sur_id;
													$liczba_surowcow--;
												} else {
													//Z pierwszej pêtli wiemy, ¿e $sur['ilosc'] >= $srednia
													$skrawek -= $sur['ilosc'] - $srednia;
													$plecaki[$sur_id]['ilosc'] = $sur['ilosc'];
													$plecaki[$sur_id]['surowiec_id'] = $sur_id;
													$liczba_surowcow--;
												}
												//Aktualizacja wartoœci dla tych, które ju¿ nie bêd¹ zmieniane
												$surowce[$klucz]['ilosc'] -= $plecaki[$sur_id]['ilosc'];
											}
										}
									}
								}
								
								//Zapis zmian surowców
								//Atak - przyniesione
								$first = true;
								$sql_transact = "INSERT INTO atak_surowce (atak_id, surowiec_id, ilosc) VALUES ";
								foreach($plecaki as $plecak) {
									if(! $first) {
										$sql_transact .=", ";
									} else {
										$first = false;
									}
									$sql_transact .= "(".$atak['id'].", ".$plecak['surowiec_id'].", ".$plecak['ilosc'].")";
								}
								mysql_query($sql_transact);
								
								//Zapis zmian surowców
								//Port - zrabowane
								$first = true;
								$sql_transact = "INSERT INTO port_surowce (port_id, surowiec_id, ilosc, updated_at) VALUES ";
								foreach($surowce as $sur) {
									if(! $first) {
										$sql_transact .=", ";
									} else {
										$first = false;
									}
									$sql_transact .= "(".$cel['port_id'].", ".$sur['surowiec_id'].", ".$sur['ilosc'].", ".$czas.")";
								}
								$sql_transact .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc), updated_at=VALUES(updated_at)";
								mysql_query($sql_transact);
								echo '<br/><br/>UPDATE budynków:<br/>'.$sql_transact;
								
								//Koniec transakcji
								$sql_transact = "COMMIT;";
								mysql_query($sql_transact);
								
								
							} else if($cel_sila > $atak_sila) {
						//Atakuj¹cy przegrywa i wraca z niczym
								$cel_straty = pow(($atak_sila/$cel_sila), 1.5);
								$atak_straty = 1.0 - $cel_straty;
								
								echo '<br/>Pora¿ka atakuj¹cego! (Coœ jest nie tak?)';
								echo '<br/>';
								echo 'Si³a ataku: '.$atak_sila;
								echo '<br/>';
								echo 'Si³a obrony: '.$cel_sila;
								
								//Pocz¹tek transakcji
								$sql_transact = "START TRANSACTION; ";
								mysql_query($sql_transact);
								
								//Straty dla portu
								foreach($cel_jednostki as $cj) {
									$sql_transact = "INSERT INTO atak_jednostki (atak_id, jednostka_id, czy_obronca, ilosc_wyjscie, ilosc_powrot)
										VALUES (".$atak['id'].", ".$cj['jednostka_id'].", 1, ".$cj['ilosc'].", ";
								
									$cj['ilosc'] -= round($cel_straty * $cj['ilosc']);
									
									$sql_transact .= $cj['ilosc']."); ";
									mysql_query($sql_transact);
									
									$sql_transact = "UPDATE port_jednostki SET ilosc = ".$cj['ilosc']
										." WHERE port_id=".$cel['port_id']." AND jednostka_id=".$cj['jednostka_id']."; ";
									mysql_query($sql_transact);
								}
								
								//Straty dla atakuj¹cego - AKTUALIZUJESZ ilosc_powrot
								foreach($atak_jednostki as $klucz => $aj) {
									echo '<br/>ilosc_wyjscie '.$aj['ilosc_wyjscie'];
									echo '<br/>round($aj[ilosc_wyjscie] * $atak_straty) '.round($aj['ilosc_wyjscie'] * $atak_straty);
									$ilosc_powrot = $aj['ilosc_wyjscie'] - round($aj['ilosc_wyjscie'] * $atak_straty);
									$atak_jednostki[$klucz]['ilosc_powrot'] = $ilosc_powrot;
									echo '<br/>$ilosc_powrot = '.$ilosc_powrot;
									echo '<br/>$aj[ilosc_powrot] = '.$aj['ilosc_powrot'];
									
									$sql_transact = "UPDATE atak_jednostki SET ilosc_powrot=".$ilosc_powrot." WHERE atak_id=".$aj['atak_id']
										." AND jednostka_id=".$aj['jednostka_id']." AND czy_obronca=0";
									echo "<br/>Aktualizacja wracaj¹cych: ".$sql_transact;
									mysql_query($sql_transact);
								}
								
								//Koniec transakcji
								$sql_transact = "COMMIT;";
								mysql_query($sql_transact);
								
								
							} else {
						//95% strat po obu stronach - MASAKRA
								echo 'MASAKERAW. The MASAKERAW.';
								$cel_straty = 0.95;
								$atak_straty = 0.95;
								
								//Pocz¹tek transakcji
								$sql_transact = "START TRANSACTION; ";
								mysql_query($sql_transact);
								
								//Straty dla portu
								foreach($cel_jednostki as $cj) {
									$sql_transact = "INSERT INTO atak_jednostki (atak_id, jednostka_id, czy_obronca, ilosc_wyjscie, ilosc_powrot)
										VALUES (".$atak['id'].", ".$cj['jednostka_id'].", 1, ".$cj['ilosc'].", ";
								
									$cj['ilosc'] -= round($cel_straty * $cj['ilosc']);
									
									$sql_transact .= $cj['ilosc']."); ";
									mysql_query($sql_transact);
									
									$sql_transact = "UPDATE port_jednostki SET ilosc = ".$cj['ilosc']
										." WHERE port_id=".$cel['port_id']." AND jednostka_id=".$cj['jednostka_id']."; ";
									mysql_query($sql_transact);
								}
								
								//Straty dla atakuj¹cego - AKTUALIZUJESZ ilosc_powrot
								foreach($atak_jednostki as $klucz => $aj) {
									echo '<br/>ilosc_wyjscie '.$aj['ilosc_wyjscie'];
									echo '<br/>round($aj[ilosc_wyjscie] * $atak_straty) '.round($aj['ilosc_wyjscie'] * $atak_straty);
									$ilosc_powrot = $aj['ilosc_wyjscie'] - round($aj['ilosc_wyjscie'] * $atak_straty);
									$atak_jednostki[$klucz]['ilosc_powrot'] = $ilosc_powrot;
									echo '<br/>$ilosc_powrot = '.$ilosc_powrot;
									echo '<br/>$aj[ilosc_powrot] = '.$aj['ilosc_powrot'];
									
									$sql_transact = "UPDATE atak_jednostki SET ilosc_powrot=".$ilosc_powrot." WHERE atak_id=".$aj['atak_id']
										." AND jednostka_id=".$aj['jednostka_id']." AND czy_obronca=0";
									echo "<br/>Aktualizacja wracaj¹cych: ".$sql_transact;
									mysql_query($sql_transact);
								}
								
								//Koniec transakcji
								$sql_transact = "COMMIT;";
								mysql_query($sql_transact);
								
								
							}
							
							//Zmiana statusu ataku na wracaj¹cy
							$atak['status'] = 2;
							$sql = "UPDATE ataki SET status=2 WHERE id=".$atak['id'];
							mysql_query($sql);
							
							$queue->insert($atak,$atak['dataPowrotu']);
						}
					}
				} else if($czubek['status'] == 2 && strtotime($czubek['dataPowrotu']) <= $czas) {
					//Powrót
					$atak = $queue->extract();
					
					$sql = "SELECT * FROM port_jednostki AS sj JOIN jednostki AS j
						ON (sj.jednostka_id = j.id)
						WHERE port_id=".$atak['atakujacy_port_id']." ORDER BY jednostka_id ASC";
					echo '<br/>'.$sql;
					$result = mysql_query($sql);
					$home_jednostki = array();
					while($row=mysql_fetch_assoc($result)){
						$home_jednostki[] = $row;
						echo '<br/>'.$row['jednostka_id'];
					}
					
					$sql = "SELECT *
						FROM atak_jednostki AS aj JOIN jednostki AS j
						ON (aj.jednostka_id = j.id)
						WHERE atak_id=".$atak['id']." AND czy_obronca = 0
						ORDER BY jednostka_id ASC";
					echo '<br/>'.$sql;
					$result = mysql_query($sql);
					$atak_jednostki = array();
					while($row=mysql_fetch_assoc($result)) {
						$atak_jednostki[] = $row;
					}
					
					//Pocz¹tek INSERT INTO ... ON DUPLICATE KEY UPDATE ...
					//UWAGA - zwiêksza wartoœæ AUTO_INCREMENT, zatem NIE U¯YWAÆ TEGO W TABELACH Z AUTO_INCREMENT!!!
					$sql = "INSERT INTO port_jednostki (port_id, jednostka_id, ilosc)
						VALUES ";
					
					$first = true;
					
					foreach($atak_jednostki as $klucz => $aj) {
						echo '<br/>Pêtla dla jednostki id'.$aj['jednostka_id'];
						$i = count($home_jednostki) - 1;
						$brak = true;
						
						while($brak && $i >= 0) {
							echo '<br/>$i: '.$i;
							if($home_jednostki[$i]['jednostka_id'] == $aj['jednostka_id']) {
								echo '<br/>id jednostki: '.$aj['jednostka_id'];
								echo '<br/>Powrót krótka nazwa przed: '.$aj['ilosc_powrot'];
								echo '<br/>Home jednostki przed: '.$home_jednostki[$i]['ilosc'];
								$atak_jednostki[$klucz]['ilosc_powrot'] += $home_jednostki[$i]['ilosc'];
								echo '<br/>Powrót d³uga nazwa: '.$atak_jednostki[$klucz]['ilosc_powrot'];
								echo '<br/>Powrót krótka nazwa: '.$aj['ilosc_powrot'];
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
						
						$sql .= "(".$atak['atakujacy_port_id'].", ".$aj['jednostka_id'].", ".$atak_jednostki[$klucz]['ilosc_powrot'].")";
					}
					
					//UPDATE jednostek w porcie 
					$sql .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc);";
					$result = mysql_query($sql);
					
					//Zmiana statusu ataku na wracaj¹cy
					$atak['status'] = 3;
					$sql = "UPDATE ataki SET status=3 WHERE id=".$atak['id'];
					mysql_query($sql);
				} else {
					$zrobione = true;
				}
			}
			
			echo '<br/><hr/>';
			/***!**/if( $rutabaga <= 0 ) {
				/***!*****/$stop = true;
				/****!****/echo '<br/>Czas dzia³ania pêtli: '.(time() - $czas);
			}
		}
	}
	
	mysql_close($con);
	exit();
?>