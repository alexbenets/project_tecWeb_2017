<?php
$protagonista=array("nome protagonista", "nome sezione","esempio.img" "testo di presentazione, come faccio a mettere più <p>paragrafi</p>?");
	stampa_head();
	echo("
	<title>protagonista</title>
		<meta name=\"keywords\" content=\"$protagonista[0], acquario di PLACEHOLDER\" /> <!--PLACEHOLDER=dove si trova l'acquario, FISHPL=nomepesce-->
		<meta name=\"description\" content=\"pagina riguardante $protagonista[0], protagonista della sezione $protagonista[1]\" />
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
				<span>$protagonista[1]</span>
				<span>$protagonista[0]</span>
			</div><!-- chiudo path-->
		
		</div><!-- chiudo header-->
				<div id=\"main\"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
		
			<div id=\"contenuto\">
				<h1>$protagonista[0]</h1>
				<div id=\"imgFish\"></div>
				<!--or 
				<img alt=\"\" src=\"$protagonista[3]\"></img>
				-->
				<div>
				<p>$protagonista[3]</p>
				</div>
			</div><!-- chiudo contenuto-->

		</div><!-- chiudo main-->
	");
	stampa_footer();
?>