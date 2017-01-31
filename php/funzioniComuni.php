<?php
	function stampa_footer(){
		echo("
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
	</html>
	");
	}
	
	function stampa_head(){
		echo('
		<html xmlns="http://www.w3.org/1999/xhtml" lang="it" xml:lang="it">
			<head>
				<link rel="stylesheet" href="style/main.css" type="text/css" media="screen" charset="utf-8"/>
		');
	}
	
?>
