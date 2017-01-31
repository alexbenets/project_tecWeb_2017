<?php 
 echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="it" xml:lang="it">

	<head>
		<link rel="stylesheet" href="style/main.css" type="text/css" media="screen" charset="utf-8"/>
		<title>Notizie</title>
		<meta name="keywords" content="notizie, acquario di PLACEHOLDER" />
		<meta name="description" content="pagina contente le notizie che riguardano l\'acquario di PLACEHOLDER" />
		<meta name="author" content="GRUPPO" />
	</head>
	<body>
	<div id="header">

			<div id="banner">
				<h1>Acquario</h1>
				<h2>La magia dell\'oceano davanti a te!</h2>
				
				<div id="description">
					<span></span>
				</div>
			</div><!-- chiudo banner-->
			
			<div id="menu">
				<ul>
 					<li>
 						<a href="#home">Home</a>
 					</li>
  					<li>
  						<a href="#news">News</a>
  					</li>
  					<li>
  						<a href="#contact">Contact</a>
  					</li>
				</ul>
		
			</div><!-- chiudo menu -->
			<div class="clearer"></div>

			<div id="path">
				<span>Ti trovi in: </span>
				<span>Home</span>
				<span>Notizie</span>
			</div><!-- chiudo path-->
		
		</div><!-- chiudo header-->
		<div id="main"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
			<div id="contenuto">';

$notizie=array("titolo notizia"=>"gg/mm/aaaa+testo notizia", "notizia1"=>"12/02/2015+testo1", 
	"titolo notiziaa"=>"gg/mm/aaaa+testo notiziai love my work yannnow", "notizia10"=>"12/02/2015+testo1fssfoubeub dfuow wef", 
	"titolo notiz"=>"gg/mm/aaaa+testo notizia lowe is a lie sdabioav ", "notizia12"=>"12/02/2015+testo1ssssssssss avofoug",
	"titolo notzia"=>"gg/mm/aaaa+testo notizia asredf", "notizsfdia1"=>"12/02/2015+testo1 aufvo",
	"titolo notizias"=>"gg/mm/aaaa+testo notisdzia", "notsdffeaizia1"=>"12/02/2015+testo1", 
	"titologg notizia"=>"gg/mm/aaaa+testo notizia", "notizffia1"=>"12/02/2015+testo1",
	"titolo noukytizia"=>"gg/mm/aaaa+testo notizia", "notizixxeea1"=>"12/02/2015+testo1");

foreach ($notizie as $titolo => $contenuto){ //!!! NB in quello vero dovremo ORDINARE in base alla data (dalla + recente alla meno recente)
echo ("
	<div class=\"notizia\">
	<h1>$titolo</h1>
	<p>");
	$data=strchr($contenuto,"+",true);
	$testo=strchr($contenuto,"+",false);
echo("
	$data</p>
	<p>$testo</p>
	</div>"); //!!! NB nella versione finale bisogna fare in modo che eventuali " ' " nel testo o nel titolo siano interpretati correttamente (se non usiamo variabili come qui)
}

echo("<button type=\"button\">precedenti</button>
			<button type=\"button\">successive</button>			
			</div><!-- chiudo contenuto-->

		</div><!-- chiudo main-->
				<div id=\"footer\">

			<div id=\"sitemap\">
				<a href=\"siteMap.html\">Mappa del sito</a>
			</div> <!-- chiudo sitemap -->
			<div id=\"dati_aziendali\">
				<p>Acquario</p>
				<p>P.IVA: 0764352056C</p>
			</div><!-- chiudo dati aziendali -->
			<div id=\"gruppo\">
				<p>An project by: MarAlFraMar</p>
			</div><!-- chiudo div del gruppo -->
			
			<div id=\"validazione\">
				<p class=\"html_valido\">
    				<a href=\"http://validator.w3.org/check?uri=referer\">
						<img src=\"http://www.w3.org/Icons/valid-xhtml10\" alt=\"Valid XHTML 1.0 Strict\" height=\"31\" width=\"88\" />
					</a>
	  			</p>
				<p class=\"css_valido\">
					<a href=\"http://jigsaw.w3.org/css-validator/check/referer\">
    					<img style=\"border:0;width:88px;height:31px\" src=\"http://jigsaw.w3.org/css-validator/images/vcss-blue\" alt=\"CSS Valido!\" />
    				</a>
				</p>
				<div class=\"clearer\"></div> <!-- chiudo i float -->
			</div><!-- chiudo div validazione -->

		</div><!-- chiudo footer-->
	</body>
</html>");
	
?>