<?php 
	session_start();
	require "database.php";
	
	$_SESSION['page']="prenota.php";
	
	/* controllo se ho effettuato l'accesso */
	$biglietti = leggi_tipologie_di_prenotazione();
	$link_prenotazione='<a href="login.php">Accedi per prenotare</a>';
	if ($_SESSION['login']==1){
	}else{
	
	}
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="it" xml:lang="it">

	<head>
		<link rel="stylesheet" href="style/main.css" type="text/css" media="screen" charset="utf-8"/>
		<title>biglietti</title>
		<meta name="keywords" content="biglietti, singoli, gruppi, scolaresche, acquario di PLACEHOLDER" />
		<meta name="description" content="pagina relativa ai prezzi dei bilgietti per l'acquario di PLACEHOLDER" />
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
 						<a href="index.html">Home</a>
 					</li>
  					<li>
  						<a href="#sale">Sale</a>
  					</li>
  					<li>
  						<a href="#sede">Sede</a>
  					</li>
  					<li>
  						<a href="#storia">Storia</a>
  					</li>
  					<li>
  						<a href="#educazione">Educazione all'ambiente</a>
  					</li>
  					<li>
  						<a class="active" href="#biglietti">Biglietti</a>
  					</li>
  					<li>
  						<a href="#chi siamo">Chi siamo</a>
  					</li>
  					<li>
  						<a href="#orario">Orario</a>
  					</li>
  					<li>
  						<a href="#contatti">Contatti</a>
  					</li>
  					<li>
  						<a href="#pagina utente">Pagina utente</a>
  					</li>
				</ul>
			</div><!-- chiudo menu -->
			<div class="clearer"></div>

			<div id="path">
				<span>Ti trovi in: </span>
				<span>Home</span>
				<span>Biglietti</span>
			</div><!-- chiudo path-->
		
		</div><!-- chiudo header-->
				<div id="main"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
		
			<div id="contenuto">
			<div id="box">
				<?php
					$titolo="";
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
					print "<dd>&euro;$prezzo_biglietto</dd>";
					}
				?>
				
					</dl>
				</div>
				</div><!--box-->
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