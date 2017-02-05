<?php
	/*
		per impostare il menù
	
	*/
	$menu= array();
	$menu['Home']="index.html";
	$menu['Esposizioni']="esposizioni.html";
	$menu['Sede']="sede.html";
	$menu['Storia']="storia.html";
	$menu['Educazione all\'ambiente']="educazione.html";
	$menu['Biglietti']="prenotazione.php";
	$menu['Orario']="orario.html";
	$menu['Come arrivare']="comeArrivare.html";
	$menu['Contatti']="contatti.html";
	$menu['Pagina utente']="login.php?area_utente=1";
	
	function stampa_footer(){
		?>
		</div><!-- chiudo main-->

		<div id="footer">
			<div id="dati_aziendali">
				<p>Acquario di PLACEHOLDER</p>
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
			</div><!-- chiudo div validazione -->

			<div id="sitemap">
				<a href="siteMap.html">Mappa del sito</a>
			</div> <!-- chiudo sitemap -->

		</div><!-- chiudo footer-->

	</body>
</html>
		
		<?php
	}
	
	function stampa_head($path, $nome_attivo){
		global $menu;
		?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="it" xml:lang="it">
	
	<head>
		<link rel="stylesheet" href="style/main.css" type="text/css" media="screen" charset="utf-8"/>
		<title><?php print $nome_attivo;?> - Acquario di Thalassa</title>

		<meta name="title" content="Acquario di Thalassa" />
		<meta name="description" content="Home page del sito di Acquario di Thalassa" />
		<meta name="keywords" content="Acquario, pesci, acqua, barriera corallina, oceano" />
		<meta name="language" content="italian it" />
		<meta name="author" content="Gruppo MarAlFraMar" />

	</head>
	
	<body>
		<div id="header">
			<div id="banner">
				<h1>Acquario di Thalassa</h1>
				<h2>La magia dell'oceano davanti a te!</h2>
			</div><!-- chiudo banner-->			
		</div><!-- chiudo header-->	
		
		<div id="path">
			<span>Ti trovi in: </span>
			<span><?php print $path; ?></span>
		</div><!-- chiudo path-->

		<div id="nav">
			<ul>
				<?php
				
				$attivo="";	
				foreach ($menu as $nome => $link) {
					if ($nome==$nome_attivo){
						$attivo='class="active"';
					}
					print"
						<li>
							<a $attivo href=\"$link\">$nome</a>
						</li>
					";
					$attivo='';
				}
				?>
				
			</ul>
		</div><!-- chiudo nav -->

		<div id="main"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
			<!-- <img id="imgHomePage" src="imageBackground/background.jpg" alt="Barriera corallina"/> -->
		<?php
	}
	
?>
