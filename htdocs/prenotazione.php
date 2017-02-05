<?php 
	session_start();
	require "database.php";
	require "funzioniComuni.php";
		
	$_SESSION['page']="prenotazione.php";
	if(!isset($_SESSION['login'])){
		$_SESSION['login']="";
	}
	/* controllo se ho effettuato l'accesso */
	$biglietti = leggi_tipologie_di_prenotazione();
	$link_prenotazione='<a href="login.php">Accedi per prenotare</a>';
	$step=0;
	
	$numero_elementi_prenotazione = 0;
	
	if(isset($_POST['numero_elementi'])){
		$numero_elementi_prenotazione=$_POST['numero_elementi'];
	}
	if(isset($_GET['step'])){
		$step=$_GET['step'];
	}
	if(isset($_POST['step'])){
		$step=$_POST['step'];
	}
	if (isset($_SESSION['login'])){
		if ($_SESSION['login']!=""){
			$link_prenotazione='<a href="prenota.php?step=1">Prenota un biglietto!</a>';
		}
	}else{
		$step=0;
	}
	
	$errori = "";
	
	$data="";
	$selezione_tipo_biglietto = array($numero_elementi_prenotazione);
	$quantita_biglietti = array($numero_elementi_prenotazione);
	/* se ho inviato il modulo */
	if(isset($_POST['invia'])){
		$i=0;
		for ($i=0; $i<$numero_elementi_prenotazione; $i++){
			if (isset($_POST['tipo_biglietto'.$i])){
				$selezione_tipo_biglietto[$i] = $_POST['tipo_biglietto'.$i];
			}else{
				$selezione_tipo_biglietto[$i]=-1;
			}
			if (isset($_POST['numero_biglietti'.$i])){
				$quantita_biglietti[$i] = $_POST['numero_biglietti'.$i];
			}else{
				$quantita_biglietti[$i] = -1;
			}
		}
		
		if (isset($_POST['data'])){
			$data = $_POST['data'];
		}
		/*if ($selezione_tipo_biglietto == -1){
			$errori = $errori."Attenzione: non &egrave; stato selezionato un biglietto valido.";
			$step=1;
		}
		if ($quantita_biglietti >= 50 ){
			$errori = $errori."Attenzione: non &egrave; consentito acquistare pi&ugrave; di 50 biglietti per prenotazione.";
			$step=1;
		}
		if ($quantita_biglietti < 1 ){
			$errori = $errori."Attenzione: non hai specificato la quantit&agrave; di biglietti richiesti.";
			$step=1;
		}*/
		if (controlla_data($data)==0){
			$errori = $errori."Attenzione: non hai inserito una data corretta.";
			$step=1;
		}else {
			
			$date = new DateTime(converti_data($data));
			$now = new DateTime();
			if ($date<$now){
				$errori = $errori."Attenzione: puoi prenotare i biglietti con almeno un giorno d'anticipo.";
				$step=1;
			}
		}
	}
	/* ho superato indenne la fase di verifica, procedo con la prenotazione.*/
	if ($step==2){
		/* semplice verifica contro i ricaricamenti della pagina. */
		if($_POST['rnd_str']==$_SESSION['rnd_prenotazione']){
			/* consumo il token */
			$_SESSION['rnd_prenotazione']="0";
			$i=0;
			$res=0;
			for ($i=0; $i<count($quantita_biglietti); $i++){
				if(($quantita_biglietti[$i]>0) & ($selezione_tipo_biglietto[$i]>0)){
					$res=prenota($data, $quantita_biglietti[$i], $selezione_tipo_biglietto[$i], $_SESSION['userID']);
				}
				if ($res!=2){
					$errori = $errori ."Attenzione: qualcosa &egrave; andato storto durante la prenotazione, la prenotazione &egrave; stata annullata.";
					$i=count($quantita_biglietti)+1;
				}
			}
		}else{
			$res=0;
			$errori=$errori."Attenzione: hai gi&agrave; effettuato questa prenotazione.";
		}
	}
	
	stampa_head('Prenotazione biglietti', "Biglietti");
?>


			<div id="content">
			<div id="box">
				<?php
					$titolo="";
					if (($step==0) & ($_SESSION['login']=="")){
						foreach ($biglietti as &$riga ){
							/* se cambio il titolo*/
							if ($riga['note_varie']!=$titolo){			
								if ($titolo!=""){
								?>
						</dl>
						<?php
							print $link_prenotazione;
						?>
					</div>
								<?php
								}
								
								$titolo = $riga['note_varie'];
								?>
							
					<div class="biglietto">
					<?php
								print "<h2>$titolo</h2>";
					?>
						<dl>
					<?php
							}
							
							$nome_biglietto = $riga['nome'];
							$descrizione_biglietto=$riga['descrizione'];
							$prezzo_biglietto = $riga['prezzo'];
							print "<dt>$nome_biglietto $descrizione_biglietto</dt>";
							if ($prezzo_biglietto!=0){
								print "<dd>&euro;$prezzo_biglietto</dd>";
							}else{
								print "<dd>GRATIS</dd>";
							}
						}
					?>
					
					</dl>
				</div>
				<?php
					}
					
					if (($step<2) & ($_SESSION['login']!="")){
						/*  genero una stringa casuale, così da evitare doppie prenotazioni */
						$_SESSION['rnd_prenotazione'] = bin2hex(mcrypt_create_iv(22, MCRYPT_DEV_URANDOM));
						$num_elementi=0;
					?>
					<div class="biglietto">
						<h3>Prenota la tua visita!</h3>
						<form action="prenotazione.php" method="post">
							<fieldset>
									<?php
										
										$titolo="";
										$prezzo=0;
										$num_elementi=0;
										foreach ($biglietti as &$riga ){
											if(!isset($quantita_biglietti[$num_elementi-1])){
												$quantita_biglietti[$num_elementi-1]=1;
											}
											if ($riga['note_varie']!=$titolo){	
												if($titolo==""){
													$titolo=$riga['note_varie'];
												}else{
												?>
								</select>
								<label for="numero_biglietti<?php print $num_elementi-1;?>">Numero di biglietti da acquistare</label>
								<input type="text" name="numero_biglietti<?php print $num_elementi-1;?>" id="numero_biglietti<?php print $num_elementi-1;?>" value="<?php 
																																										if(isset($_POST['step'])){
																																											print $quantita_biglietti[$num_elementi-1];
																																										}else{
																																											print 1;
																																										} ?>" />
												<?php
												}
												?>
												<h3><?php print $riga['note_varie']; ?></h3>
												<label for="tipo_biglietto<?php print $num_elementi;?>">Seleziona il biglietto che desideri prenotare</label>
												<select name="tipo_biglietto<?php print $num_elementi;?>" id="tipo_biglietto<?php print $num_elementi;?>">
												<option value ="-1" selected="selected" disabled="disabled">Seleziona</option>
												<?php
												print '<option value="-1" disabled="disabled">'.$titolo.'</option>';
											}
											$titolo = $riga['note_varie'];
											print '<option value="'.$riga['ID_Tipologia_Prenotazione'].'" ';
											
											/*if ($riga['ID_Tipologia_Prenotazione']==$selezione_tipo_biglietto){
												print ' selected="selected"';
											}*/
											
											print '>'.$riga['nome'].' ';
											$prezzo=$riga['prezzo'];
											if($prezzo>0){
												$prezzo="&euro; ".$prezzo;
											}else{
												$prezzo = "GRATIS";
											}
											print $prezzo.'</option>';
											$num_elementi ++;
										}
								if($num_elementi>0){
								
											//$num_elementi ++;
								?>
								
								</select>
								<input type="hidden" name="numero_elementi" id="numero_elementi" value="<?php print $num_elementi?>"/>
								<label for="numero_biglietti<?php print $num_elementi-1;?>">Numero di biglietti da acquistare</label>
								<input type="text" name="numero_biglietti<?php print $num_elementi-1;?>" id="numero_biglietti<?php print $num_elementi-1;?>" value="<?php 
																																										if(isset($_POST['step'])){
																																											print $quantita_biglietti[$num_elementi-1];
																																										}else{
																																											print 1;
																																										} ?>" />
								<?php
								}
								?>
								<p></p>
								<label for="data">Data di arrivo: </label>
								<input type="text" name="data" id="data" value="<?php
									if ($data==""){
										echo date("Y").'/'.date("m").'/'.date("d");
									} else 
									{
										echo $data;
									} 
								?>" />
								<input type="submit" name="invia" id="invia" value="Prenota" />
								<input type="hidden" name="step" value="2"/>
								<!-- token per la prenotazione -->
								<input type="hidden" name="rnd_str" value="<?php print $_SESSION['rnd_prenotazione'];?>"/>
								<?php
									if ($errori!=""){
										?>
										<h2 class="warning"><?php print $errori;?></h2>
										<?php
									}
								?>
							</fieldset>
						</form>
					<?php
					
					
					?>
					</div>
					<?php
					}
					if(($step==2) & ($errori=="")){
						?>
							<h3>Complimenti, la prenotazione &egrave; stata effettuata!</h3>
							<p>Recati il giorno <?php print $data; ?> per pagare in cassa e ricevere il biglietto d'ingresso!</p>
							<p><a href="index.html">Torna alla homepage</a></p>
							<p><a href="login.php?area_utente=1">Gestisci il tuo profilo</a></p>
						<?php
					}else{
						print "<h3>$errori</h3>";
						?>
						<p><a href="index.html">Torna alla homepage</a></p>
						<p><a href="login.php?area_utente=1"><?php 
										if($_SESSION['login']!="")
										{print "Gestisci il tuo profilo";}
										else
										{print "Accedi per prenotare";} ?></a></p>
						<?php
					}
					
				?>
				
				</div><!--box-->
			</div><!-- chiudo contenuto-->
			
<?php
	stampa_footer();

?>