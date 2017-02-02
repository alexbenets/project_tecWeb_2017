<?php 
	session_start();
	require "database.php";
	
	$_SESSION['page']="prenota.php";
	
	/* controllo se ho effettuato l'accesso */
	$biglietti = leggi_tipologie_di_prenotazione();
	$link_prenotazione='<a href="login.php">Accedi per prenotare</a>';
	$step=0;
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
	$selezione_tipo_biglietto = -1;
	$quantita_biglietti = 1;
	/* se ho inviato il modulo */
	if(isset($_POST['invia'])){
		if (isset($_POST['tipo_biglietto'])){
			$selezione_tipo_biglietto = $_POST['tipo_biglietto'];
		}
		if (isset($_POST['data'])){
			$data = $_POST['data'];
		}
		if (isset($_POST['numero_biglietti'])){
			$quantita_biglietti = $_POST['numero_biglietti'];
		}else{
			$quantita_biglietti = -1;
		}
		if ($selezione_tipo_biglietto == -1){
			$errori = $errori."<p>Attenzione: non &egrave; stato selezionato un biglietto valido.</p>";
			$step=1;
		}
		if ($quantita_biglietti >= 50 ){
			$errori = $errori."<p>Attenzione: non &egrave; consentito acquistare pi&ugrave; di 50 biglietti per prenotazione.</p>";
			$step=1;
		}
		if ($quantita_biglietti < 1 ){
			$errori = $errori."<p>Attenzione: non hai specificato la quantit&agrave; di biglietti richiesti.</p>";
			$step=1;
		}
		if (controlla_data($data)==0 ){
			$errori = $errori."<p>Attenzione: non hai inserito una data corretta.</p>";
			$step=1;
		}else {
			
			$date = new DateTime(converti_data($data));
			$now = new DateTime();
			if ($date<$now){
				$errori = $errori."<p>Attenzione: la data dev'essere nel futuro.</p>";
				$step=1;
			}
		}
	}
	/* ho superato indenne la fase di verifica, procedo con la prenotazione.*/
	if ($step==2){
		$res=prenota($data, $quantita_biglietti, $selezione_tipo_biglietto, $_SESSION['userID']);
		if ($res!=2){
			$errori = $errori ."<p>Attenzione: qualcosa &egrave; andato storto durante la prenotazione, la prenotazione &egrave; stata annullata.</p>";
		}
		
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="it" xml:lang="it">

	<head>
		<link rel="stylesheet" href="style/main.css" type="text/css" media="screen" charset="utf-8"/>
		<title>biglietti</title>
		<meta name="keywords" content="biglietti, singoli, gruppi, scolaresche, acquario di Thalassa" />
		<meta name="description" content="pagina relativa ai prezzi dei bilgietti per l'acquario di Thalassa" />
		<meta name="language" content="italian it" />
		<meta name="author" content="GRUPPO" />
	</head>
	<body>
	<div id="header">

			<div id="banner">
				<h1>Acquario</h1>
				<h2>La magia dell'oceano davanti a te!</h2>
				
				<div id="description">
					<span></span>
				</div>
			</div><!-- chiudo banner-->
			
			<div id="menu">
				<ul>
 					<li>
					<a href="index.html">
						<span xml:lang="en">
							Home
						</span>
					</a>
				</li>
				<li>
					<a href="esposizioni.html">Esposizioni</a>
				</li>
				<li>
					<a href="sede.html">Sede</a>
				</li>
				<li>
					<a href="storia.html">Storia</a>
				</li>
				<li>
					<a href="educazione.html">Educazione all'ambiente</a>
				</li>
				<li>
					<a href="prenota.php">Biglietti</a>
				</li>
				<li>
					<a href="orario.html">Orario</a>
				</li>
				<li>
					<a href="comeArrivare.html">Come arrivare</a>
				</li>
				<li>
					<a href="contatti.html">Contatti</a>
				</li>
				<li>
					<a href="#pagina utente">Pagina utente</a>
				</li>
				</ul>
			</div><!-- chiudo menu -->
			<div class="clearer"></div>

			<div id="path">
				<span>Ti trovi in: </span>
				<span><a href="index.html">Home</a></span>
				<span>Biglietti</span>
			</div><!-- chiudo path-->
		
		</div><!-- chiudo header-->
			<div id="main"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
		
			<div id="content">
				<?php
					$titolo="";
					if ($step==0){
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
					
					if ($step==1){
					?>
					<div class="biglietto">
						<h3>Prenota la tua visita!</h3>
						<form action="prenota.php" method="post">
							<fieldset>
								<label for="tipo_biglietto">Seleziona il biglietto che desideri prenotare</label>
								<select name="tipo_biglietto" id="tipo_biglietto">
									<option value ="-1" selected="selected" disabled="disabled">Seleziona</option>
									<?php
										$titolo="";
										$prezzo=0;
										foreach ($biglietti as &$riga ){
											if ($riga['note_varie']!=$titolo){	
												if($titolo==""){
													$titolo=$riga['note_varie'];
												}
												print '<option value="-1" disabled="disabled">'.$titolo.'</option>';
											}
											$titolo = $riga['note_varie'];
											print '<option value="'.$riga['ID_Tipologia_Prenotazione'].'" ';
											
											if ($riga['ID_Tipologia_Prenotazione']==$selezione_tipo_biglietto){
												print ' selected="selected"';
											}
											
											print '>'.$riga['nome'].' ';
											$prezzo=$riga['prezzo'];
											if($prezzo>0){
												$prezzo="&euro; ".$prezzo;
											}else{
												$prezzo = "GRATIS";
											}
											print $prezzo.'</option>';
										}
									?>
								</select>
								<label for="numero_biglietti">Numero di biglietti da acquistare</label>
								<input type="text" name="numero_biglietti" id="numero_biglietti" value="<?php print $quantita_biglietti; ?>" />
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
							<p><a href="index.html">Torna alla homepage</a></p>
						<?php
					}
					
				?>
			</div><!-- chiudo contenuto-->
			
		</div><!-- chiudo main-->
				<div id="footer">

			<div id="sitemap">
				<a href="siteMap.html">Mappa del sito</a>
			</div> <!-- chiudo sitemap -->
			<div id="dati_aziendali">
				<p>Acquario</p>
				<p>P.IVA: 0764352056C</p>
			</div><!-- chiudo dati aziendali -->
			<div id="gruppo">
				<p>An project by: MarAlFraMar</p>
			</div><!-- chiudo div del gruppo -->
			
			<div id="validazione">
				<p class="html_valido">
    				<a href="http://validator.w3.org/check?uri=referer">
						<img src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" />
					</a>
	  			</p>
				<p class="css_valido">
					<a href="http://jigsaw.w3.org/css-validator/check/referer">
    					<img style="border:0;width:88px;height:31px" src="http://jigsaw.w3.org/css-validator/images/vcss-blue" alt="CSS Valido!" />
    				</a>
				</p>
				<div class="clearer"></div> <!-- chiudo i float -->
			</div><!-- chiudo div validazione -->

		</div><!-- chiudo footer-->
	</body>
</html>