<?php
$sezione=array("titolo sezione", "testo sezione, come faccio a mettere più <p>paragrafi</p>?", "protagonista1", "protagonista2", "protagomista3");
		stampa_head();
		echo("
		<title>esposizione</title>
		<meta name=\"keywords\" content=\"$sezione[0], $sezione[2], $sezione[3], $sezione[4], acquario di PLACEHOLDER\" />
		<meta name=\"description\" content=\"pagina di presentazione sulla sezione $sezione[0] dell'acquario\" />
		<meta name=\"author\" content=\"GRUPPO\" />
	</head>
	<body>
	<div id=\"header\">

			<div id=\"banner\">
				<h1>Acquario</h1>
				<h2>La magia dell'oceano davanti a te!</h2>
				
				<div id=\"description\">
					<span></span>
				</div>
			</div><!-- chiudo banner-->
			
			<div id=\"menu\">
				<ul>
 					<li>
 						<a href=\"#home\">Home</a>
 					</li>
  					<li>
  						<a href=\"#news\">News</a>
  					</li>
  					<li>
  						<a href=\"#contact\">Contact</a>
  					</li>
				</ul>
		
			</div><!-- chiudo menu -->
			<div class=\"clearer\"></div>

			<div id=\"path\">
				<span>Ti trovi in: </span>
				<span>Home</span>
				<span>Esposizioni</span>
				<span>$sezione[0]</span>
			</div><!-- chiudo path-->
		
		</div><!-- chiudo header-->
				<div id=\"main\"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
		
			<div id=\"contenuto\">
				<h1>$sezione[]</h1>
				<div>
				<p>$sezione[1]</p>
				<ul><!--elenco delle pagine dei protagonisti-->");
//!!!NB IDEM a quanto presente nella pagina sezione.php->è lo stesso concetto diversi bottoni usati x chiamare una funzione(?) che crei una pagina sull'argomento richiesto tra quelli disponibili
	$protagonisti=array();
	for($x = 2; $x < count($sezione); $x++) {//[0] e [1] di $sezione conterranno sempre titolo e testo, tutte le successive caselle contengono nomi di protagonisti della sezione 
		array_push($protagonisti, $sezione[$x]);
	}
	$arrlength = count($protagonisti);

	for($x = 0; $x < $arrlength; $x++) {
		//serve una funzione che al click del relativo link crei una pagina... -> sezione con corrispondente dati
		echo("<li><a href=\"#\">$protanisti[$x]</a></li>");
	}
	echo("
		</ul>
		</div>
		</div><!-- chiudo contenuto-->
		</div><!-- chiudo main-->
	");
	stampa_footer();
?>