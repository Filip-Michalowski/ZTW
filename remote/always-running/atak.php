<?php
	$host="127.0.0.1"; //replace with database hostname 
	$username="root"; //replace with database username 
	$password=""; //replace with database password 
	$db_name="laravel"; //replace with database name 

	$con=mysql_connect("$host", "$username", "$password")or die("cannot connect"); 
	mysql_select_db("$db_name")or die("cannot select DB");
	
	
	/*
		WA�NE!
		Tymczasowo ingore_user_abort jest ustawione na 'false', a time_limit na 0.
		Podczas implementacji cz�ci serwerowej trzeba b�dzie zmodyfikowa� te warto�ci,
		gdy� b�d� one obs�ugiwane CRONem.
		(Notka dla siebie: doda� wtedy modu� do wczytywania)
	*/
	//ignore_user_abort(true);
	ignore_user_abort(false);
	set_time_limit(0);
	
	echo 'FULLY OPERATIONAL<br/>';
	
	demon();
	
	class KolejkaPriorytetowa extends SplPriorityQueue {
		public function compare($priority1, $priority2) 
		{
			if ($priority1 === $priority2)
				return 0;
			
			//Daty wcze�niejsze maj� ni�szy priorytet
			return $priority1 > $priority2 ? -1 : 1;
		}
	}
	
	function demon() {
		//Kolejka priorytetowa
		//Daty wcze�niejsze maj� ni�szy priorytet
		//Biblioteka Spl jest dost�pna dla php >= 5.3, ale nie ma to znaczenia, bo laravel wymaga >= 5.4
		$queue = new KolejkaPriorytetowa();
		
		//Warunek stopu: na przysz�o��, do implementacji periodycznego od�wie�ania.
		$stop = false;
		
		//Licznik rozpocz�tych p�tli, na przysz�o��:
		//0 - pierwszy rozruch, trzeba wczyta� niedoko�czone
		//3600/7200/86.400 - d�ugo chodzi? Refresh.
		$rutabaga = 300;
		
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
			
			//Dodanie nowych atak�w do kolejki
			$sql = "SELECT * FROM ataki WHERE status = 0";
			$result = mysql_query($sql);
			
			if(mysql_num_rows($result)) {
				while($row=mysql_fetch_assoc($result)){
					$sql = "UPDATE ataki SET status = 1 WHERE id =".$row['id'];
					mysql_query($sql);
					
					$row['status']=1;
					
					$queue->insert($row,$row['dataBojki']);
				}
			}
			
			$czas = time();
			
			//Cz�� w�a�ciwa
			$zrobione = false;
			
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
						$cel_jednostki = array();
						while($row=mysql_fetch_assoc($result)){
							$cel_jednostki[] = $row;
						}
						
						//Zak�adamy, �e istnieje co najmniej 1 jednostka w ataku
						//Istnienie ataku bez jednostek jest b��dem!
						$sql = "SELECT *
							FROM atak_jednostki AS aj JOIN jednostki AS j
							ON (aj.jednostka_id = j.id)
							WHERE atak_id=".$atak['id']." AND czy_obronca = 0
							ORDER BY jednostka_id ASC";
						$result = mysql_query($sql);
						$atak_jednostki = array();
						while($row=mysql_fetch_assoc($result)) {
							$atak_jednostki[] = $row;
						}
						
						if($cel_port['gracz_id'] == $atak['atakujacy_gracz_id']) {
							//Relokacja
							//W�asny (sprzymierzony) port
														
							//Pocz�tek INSERT INTO ... ON DUPLICATE KEY UPDATE ...
							//UWAGA - zwi�ksza warto�� AUTO_INCREMENT, zatem NIE U�YWA� TEGO W TABELACH Z AUTO_INCREMENT!!!
							$sql = "INSERT INTO port_jednostki (port_id, jednostka_id, ilosc)
								VALUES ";
							
							$first = true;
							
							foreach($atak_jednostki as $klucz => $aj) {
								$i = count($cel_jednostki) - 1;
								$brak = true;
								
								while($brak && $i >= 0) {
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
							
							$sql .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc);";
							$result = mysql_query($sql);
							
							//SUROWCE
							$sql = "SELECT * FROM port_surowce WHERE port_id=".$cel['port_id'];
							$result = mysql_query($sql);
							$home_surowce = array();
							while($row=mysql_fetch_assoc($result)) {
								$home_surowce[] = $row;
							}
							
							$sql = "SELECT * FROM atak_surowce WHERE atak_id=".$atak['id'];
							$result = mysql_query($sql);
							$atak_surowce = array();
							while($row=mysql_fetch_assoc($result)) {
								$atak_surowce[] = $row;
							}
							
							$sql = "INSERT INTO port_surowce (port_id, surowiec_id, ilosc, updated_at)
								VALUES ";
							
							$first = true;
							
							foreach($atak_surowce as $klucz => $aj) {
								$i = count($home_surowce) - 1;
								$brak = true;
								
								while($brak && $i >= 0) {
									if($home_surowce[$i]['surowiec_id'] == $aj['surowiec_id']) {
										$atak_surowce[$klucz]['ilosc'] += $home_surowce[$i]['ilosc'];
										$atak_surowce[$klucz]['ilosc'] = min($atak_surowce[$klucz]['ilosc'], $home_surowce[$i]['magazyn']);
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
								
								$sql .= "(".$atak['atakujacy_port_id'].", ".$aj['surowiec_id'].", ".$atak_surowce[$klucz]['ilosc']
									.", '".date('Y-m-d H:i:s',$czas)."')";
							}
							
							$sql .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc);";
							$result = mysql_query($sql);
							
							//Zg�oszenie ko�ca przetwarzania tego ataku
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
							
							//U�ywamy Travianowej formu�y strat (na przysz�o�� a'la GalCiv?)
							//950 vs 1000 oraz 1050 vs 1000 generuje diametrialne r�ne straty dla 1000 (93% dla pierwsze, 6% dla drugiej)
							//Prawdopodobnie jest tak dobrana, by bliskie starcia by�y nieprzewidywalne
							//Dla zwyci�zc�w (prz_sila/zw_sila)^1.5
							//i przegranych 1 - (prz_sila/zw_sila)^1.5
							//Ustalmy, �e 90+% po obu stronach dla remisu
							
							if($cel_sila < $atak_sila) {
						//Atakuj�cy wygrywa i kradnie surowce
								$sql = "SELECT * FROM port_surowce WHERE port_id=".$cel['port_id'];
								$result = mysql_query($sql);
								$surowce = array();
								while($row=mysql_fetch_assoc($result)){
									//Odczyt i wyliczenie surowc�w
									$row['ilosc'] += round(($czas - strtotime($row['updated_at'])) / 60 * $row['rate']);
									$row['ilosc'] = min($row['ilosc'],$row['magazyn']);
									
									$surowce[]=$row;
								}
						
								$atak_straty = pow(($cel_sila/$atak_sila), 1.5);
								$cel_straty = 1.0 - $atak_straty;
								
								//Pocz�tek transakcji
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
								
								//Straty dla atakuj�cego - AKTUALIZUJESZ ilosc_powrot
								foreach($atak_jednostki as $klucz => $aj) {
									$ilosc_powrot = $aj['ilosc_wyjscie'] - round($aj['ilosc_wyjscie'] * $atak_straty);
									$atak_jednostki[$klucz]['ilosc_powrot'] = $ilosc_powrot;
									
									$sql_transact = "UPDATE atak_jednostki SET ilosc_powrot=".$ilosc_powrot." WHERE atak_id=".$aj['atak_id']
										." AND jednostka_id=".$aj['jednostka_id']." AND czy_obronca=0";
									mysql_query($sql_transact);
								}
								
								//Grabie� - skomplikowane
								$liczba_surowcow = count($surowce);
								
								$plecaki = array();
								
								$wolne_miejsce = 0;								
								foreach($atak_jednostki as $aj) {
									$wolne_miejsce += $aj['plecak'] * $aj['ilosc_powrot'];
								}
								
								//P�tla rozk�adania surowc�w
								while($liczba_surowcow > 0) {
									$pierwotna_liczba = $liczba_surowcow;
									
									
									//Wyliczenie �redniej, do kt�rej chcemy d��y� (zaokr�glone w d�, by nie przekroczy�)
									$srednia = floor($wolne_miejsce / $liczba_surowcow);
									//Wyliczenie ( ca�o�� = [[--srednia--][--srednia--]...[--srednia--][skrawek]] )
									$skrawek = $wolne_miejsce - $liczba_surowcow * $srednia;
																		
									//Je�li surowc�w jest mniej ni� w �redniej, bierz wszystkie, zajmij nimi dost�pne miejsce,
									//	i zmniejsz liczb� surowc�w, z kt�rych mo�emy pr�bowa� wzi�� ca�� �redni�
									foreach($surowce as $klucz => $sur) {
										$sur_id = $sur['surowiec_id'];
										if(!isset($plecaki[$sur_id])) {
											if($sur['ilosc'] < $srednia) {
												$wolne_miejsce -= $sur['ilosc'];
												$plecaki[$sur_id]['ilosc'] = $sur['ilosc'];
												$plecaki[$sur_id]['surowiec_id'] = $sur_id;												
												$liczba_surowcow--;
												
												//Aktualizacja warto�ci dla tych, kt�re ju� nie b�d� zmieniane
												$surowce[$klucz]['ilosc'] = 0;
											}
										}
									}
									
									//Je�li w danym przej�ciu wszystkie sk�ady surowc�w by�y wystarczaj�co du�e,
									//	by m�c z nich wzi�� ca�� �redni�, nape�nij nimi plecak
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
													//Z pierwszej p�tli wiemy, �e $sur['ilosc'] >= $srednia
													$skrawek -= $sur['ilosc'] - $srednia;
													$plecaki[$sur_id]['ilosc'] = $sur['ilosc'];
													$plecaki[$sur_id]['surowiec_id'] = $sur_id;
													$liczba_surowcow--;
												}
												//Aktualizacja warto�ci dla tych, kt�re ju� nie b�d� zmieniane
												$surowce[$klucz]['ilosc'] -= $plecaki[$sur_id]['ilosc'];
											}
										}
									}
								}
								
								//Zapis zmian surowc�w
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
								
								//Zapis zmian surowc�w
								//Port - zrabowane
								$first = true;
								$sql_transact = "INSERT INTO port_surowce (port_id, surowiec_id, ilosc, updated_at) VALUES ";
								foreach($surowce as $sur) {
									if(! $first) {
										$sql_transact .=", ";
									} else {
										$first = false;
									}
									$sql_transact .= "(".$cel['port_id'].", ".$sur['surowiec_id'].", ".$sur['ilosc'].", '".date('Y-m-d H:i:s',$czas)."')";
								}
								$sql_transact .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc), updated_at=VALUES(updated_at)";
								mysql_query($sql_transact);
								
								//Koniec transakcji
								$sql_transact = "COMMIT;";
								mysql_query($sql_transact);
								
								
							} else if($cel_sila > $atak_sila) {
						//Atakuj�cy przegrywa i wraca z niczym
								$cel_straty = pow(($atak_sila/$cel_sila), 1.5);
								$atak_straty = 1.0 - $cel_straty;
								
								//Pocz�tek transakcji
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
								
								//Straty dla atakuj�cego - AKTUALIZUJESZ ilosc_powrot
								foreach($atak_jednostki as $klucz => $aj) {
									$ilosc_powrot = $aj['ilosc_wyjscie'] - round($aj['ilosc_wyjscie'] * $atak_straty);
									$atak_jednostki[$klucz]['ilosc_powrot'] = $ilosc_powrot;
									
									$sql_transact = "UPDATE atak_jednostki SET ilosc_powrot=".$ilosc_powrot." WHERE atak_id=".$aj['atak_id']
										." AND jednostka_id=".$aj['jednostka_id']." AND czy_obronca=0";
									mysql_query($sql_transact);
								}
								
								//Koniec transakcji
								$sql_transact = "COMMIT;";
								mysql_query($sql_transact);
								
								
							} else {
						//95% strat po obu stronach - MASAKRA
								$cel_straty = 0.95;
								$atak_straty = 0.95;
								
								//Pocz�tek transakcji
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
								
								//Straty dla atakuj�cego - AKTUALIZUJESZ ilosc_powrot
								foreach($atak_jednostki as $klucz => $aj) {
									$ilosc_powrot = $aj['ilosc_wyjscie'] - round($aj['ilosc_wyjscie'] * $atak_straty);
									$atak_jednostki[$klucz]['ilosc_powrot'] = $ilosc_powrot;
									
									$sql_transact = "UPDATE atak_jednostki SET ilosc_powrot=".$ilosc_powrot." WHERE atak_id=".$aj['atak_id']
										." AND jednostka_id=".$aj['jednostka_id']." AND czy_obronca=0";
									mysql_query($sql_transact);
								}
								
								//Koniec transakcji
								$sql_transact = "COMMIT;";
								mysql_query($sql_transact);
								
								
							}
							
							//Zmiana statusu ataku na wracaj�cy
							$atak['status'] = 2;
							$sql = "UPDATE ataki SET status=2 WHERE id=".$atak['id'];
							mysql_query($sql);
							
							$queue->insert($atak,$atak['dataPowrotu']);
						}
					}
				} else if($czubek['status'] == 2 && strtotime($czubek['dataPowrotu']) <= $czas) {
					//Powr�t
					$atak = $queue->extract();
					
					
					//JEDNOSTKI
					$sql = "SELECT * FROM port_jednostki AS sj JOIN jednostki AS j
						ON (sj.jednostka_id = j.id)
						WHERE port_id=".$atak['atakujacy_port_id']." ORDER BY jednostka_id ASC";
					$result = mysql_query($sql);
					$home_jednostki = array();
					while($row=mysql_fetch_assoc($result)){
						$home_jednostki[] = $row;
					}
					
					$sql = "SELECT *
						FROM atak_jednostki AS aj JOIN jednostki AS j
						ON (aj.jednostka_id = j.id)
						WHERE atak_id=".$atak['id']." AND czy_obronca = 0
						ORDER BY jednostka_id ASC";
					$result = mysql_query($sql);
					$atak_jednostki = array();
					while($row=mysql_fetch_assoc($result)) {
						$atak_jednostki[] = $row;
					}
					
					$sql = "INSERT INTO port_jednostki (port_id, jednostka_id, ilosc)
						VALUES ";
					
					$first = true;
					
					foreach($atak_jednostki as $klucz => $aj) {
						$i = count($home_jednostki) - 1;
						$brak = true;
						
						while($brak && $i >= 0) {
							if($home_jednostki[$i]['jednostka_id'] == $aj['jednostka_id']) {
								$atak_jednostki[$klucz]['ilosc_powrot'] += $home_jednostki[$i]['ilosc'];
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
					
					$sql .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc);";
					$result = mysql_query($sql);
					
					
					//SUROWCE
					$sql = "SELECT * FROM port_surowce WHERE port_id=".$atak['atakujacy_port_id'];
					$result = mysql_query($sql);
					$home_surowce = array();
					while($row=mysql_fetch_assoc($result)) {
						$home_surowce[] = $row;
					}
					
					$sql = "SELECT * FROM atak_surowce WHERE atak_id=".$atak['id'];
					$result = mysql_query($sql);
					$atak_surowce = array();
					while($row=mysql_fetch_assoc($result)) {
						$atak_surowce[] = $row;
					}
					
					$sql = "INSERT INTO port_surowce (port_id, surowiec_id, ilosc, updated_at)
						VALUES ";
					
					$first = true;
					
					foreach($atak_surowce as $klucz => $aj) {
						$i = count($home_surowce) - 1;
						$brak = true;
						
						while($brak && $i >= 0) {
							if($home_surowce[$i]['surowiec_id'] == $aj['surowiec_id']) {
								$atak_surowce[$klucz]['ilosc'] += $home_surowce[$i]['ilosc'];
								$atak_surowce[$klucz]['ilosc'] = min($atak_surowce[$klucz]['ilosc'], $home_surowce[$i]['magazyn']);
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
						
						$sql .= "(".$atak['atakujacy_port_id'].", ".$aj['surowiec_id'].", ".$atak_surowce[$klucz]['ilosc']
							.", '".date('Y-m-d H:i:s',$czas)."')";
					}
					
					$sql .= " ON DUPLICATE KEY UPDATE ilosc=VALUES(ilosc);";
					$result = mysql_query($sql);;
					
					//Zmiana statusu ataku na wracaj�cy
					$atak['status'] = 3;
					$sql = "UPDATE ataki SET status=3 WHERE id=".$atak['id'];
					mysql_query($sql);
				} else {
					$zrobione = true;
				}
			}
			
			if($rutabaga <= 0)
				$stop = true;
		}
	}
	
	mysql_close($con);
	exit();
?>