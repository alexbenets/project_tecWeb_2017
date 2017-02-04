<?php
	stampa_head();
	echo("
	<title>Sezioni</title>
		<meta name=\"keywords\" content=\" sezioni dell'acquario di PLACEHOLDER, acquario di PLACEHOLDER\" />
		<meta name=\"description\" content=\"pagina che elenca le sezioni presenti nell'acquario\" />
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
			</div><!-- chiudo path-->
		
		</div><!-- chiudo header-->
				<div id=\"main\"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
		
			<div id=\"contenuto\">
				<h1>Sezioni</h1>
				<div>
				<ul><!--elenco delle pagine delle sezioni-->
	");
	$sezioni=array("sezione1", "sezione2", "sezione3");
	$arrlength = count($sezioni);

	for($x = 0; $x < $arrlength; $x++) {
		//serve una funzione che al click del relativo link crei una pagina... -> sezione con corrispondente dati
		echo("<li><a href=\"fSezione($sezioni[$x])\">$sezioni[$x]</a></li>");
	}
	echo("
		</ul>
		</div>
		</div><!-- chiudo contenuto-->
		</div><!-- chiudo main-->
	");
	stampa_footer();
}