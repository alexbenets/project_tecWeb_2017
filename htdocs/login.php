<?php
	session_start();
	if (isset($_GET['logout'])) {
		session_destroy();
		session_start();
	}
	include 'database.php';
	/*
		per prima cosa, controllo se ho eseguito un login
	
	*/
	
	
	$testo_errore='<h3 class="errore">*</h3>';
	
	$entra= "";
	$nome = "";
	$cognome = "";
	$dataDiNascita = "";
	$codice_fiscale = "";
	$password = "";
	$confermaPassword = "";
	$email = "";
	
	$errori=array();
	
	$errori['nome']=0;
	$errori['cognome']=0;
	$errori['dataDiNascita']=0;
	$errori['codice_fiscale']=0;
	$errori['password']=0;
	$errori['email']=0;
	
	$trovato_errori = 0;
	$utente_gia_registrato = 0;
	
	if (isset($_POST['loginF'])) {
		/*
			eseguo il login.
		*/
		if (isset($_POST['username']) & isset($_POST['password'])){
			$nome = $_POST['username'];
			$password = $_POST['password'];
			$logged= (login(trim($nome), trim($password)));
			if ($logged==1) {
				$_SESSION['login'] = $nome;
				header('Location: index.html');
			}else{
				$trovato_errori = 1;
			}
		}else {
			$trovato_errori = 1;
		}
		if ($trovato_errori == 1 ){
			$errori['nome'] = 1;
			$errori['password'] = 1;
			$nome=$_POST['username'];
			$password=$_POST['password'];
		}
	
	} else {
		/*
			sto eseguendo una registrazione per un nuovo utente.
		*/
		$entra= (isset($_POST['entra']))? $_POST['entra'] : '0';
		
		if (!(isset($_POST['Nome']))){
			$nome = "Nome";
		}
		if (!(isset($_POST['cognome']))){
			$cognome = "Cognome";
		}
		if (!(isset($_POST['dataDiNascita']))){
			$dataDiNascita = "AAAA/MM/GG";
		}
		if (!(isset($_POST['codice_fiscale']))){
			$codice_fiscale = "codice fiscale";
		}
		if (!(isset($_POST['password']))){
			$password = "pazzaword";
		}
		if (!(isset($_POST['confermaPassword']))){
			$confermaPassword = "pazzaword1";
		}
		if (!(isset($_POST['email']))){
			$email = "info@example.com";
		}
		
		/* controllo i campi */
		if ($entra=='Iscriviti') {
		
			$nome = (isset($_POST['nome']))? $_POST['nome'] : 'Nome';
			$cognome = (isset($_POST['cognome']))? $_POST['cognome'] : 'Cogome';
			$dataDiNascita = (isset($_POST['dataDiNascita']))? $_POST['dataDiNascita'] : 'GG/MM/AAAA';
			$codice_fiscale = (isset($_POST['codice_fiscale']))? $_POST['codice_fiscale'] : 'codice_fiscale';
			$password = (isset($_POST['password']))? $_POST['password'] : 'pass';
			$confermaPassword = (isset($_POST['confermaPassword']))? $_POST['confermaPassword'] : 'word';
			$email = (isset($_POST['email']))? $_POST['email'] : 'info@example.org';
			
			$risultato_regex="";
			preg_match("/[a-zA-Z\s]+/", $nome, $risultato_regex);
			if ($risultato_regex[0]!=$nome) {
				$errori['nome']=1;
				$trovato_errori = 1;
			}
			$risultato_regex="";
			preg_match("/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/", $dataDiNascita, $risultato_regex);
			if ($risultato_regex != null){
				if ($risultato_regex[0]!=$dataDiNascita) {
					$errori['dataDiNascita']=1;
					$trovato_errori = 1;
				}else {
					$dataDiNascita = str_replace('/','-', $dataDiNascita);
					print $dataDiNascita;
				}
			}else {
					$errori['dataDiNascita']=1;
					$trovato_errori = 1;
			}
			$risultato_regex="";
			preg_match("/[a-zA-Z\s]+/", $cognome, $risultato_regex);
			if ($risultato_regex[0]!=$cognome) {
				$errori['cognome']=1;
				$trovato_errori = 1;
			}
			/*$risultato_regex="";
			preg_match("/[0-9]+/", $codice_fiscale, $risultato_regex);
			if ($risultato_regex != null){
				if ($risultato_regex[0]!=$codice_fiscale) {
					$errori['codice_fiscale']=1;
					$trovato_errori = 1;
				}
			}else{
				$errori['codice_fiscale']=1;
				$trovato_errori = 1;
			}*/
			$risultato_regex="";
			preg_match("/[a-zA-Z\.0-9]+@[a-zA-Z\.0-9]+\.[a-zA-Z\.0-9]+/", $email, $risultato_regex);
			if ($risultato_regex[0]!=$email) {
				$errori['email']=1;
				$trovato_errori = 1;
			}

			
			if ($password != $confermaPassword){
				$errori['password']=1;
				$trovato_errori = 1;
			}
			if ($trovato_errori==0){
				$utente_gia_registrato=registraUtente($nome, $cognome, $dataDiNascita, $email, $codice_fiscale, $password);
			}
		}
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" lang="it" xml:lang="it">

	<head>
		<link rel="stylesheet" href="style/main.css" type="text/css" media="screen" charset="utf-8"/>
		<title>Login</title>
		<meta name="keywords" content="login, registrazione, acquario PLACEHOLDER" />
		<meta name="description" content="pagina per la registrazione e/o il login al sito" />
		<meta name="language" content="italian it" />
		<meta name="author" content="GRUPPO" />
		<meta name="robots" content="noindex, nofollow" />
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
  						<a href="sede.html">Sede</a>
  					</li>
  					<li>
  						<a href="storia.html">Storia</a>
  					</li>
  					<li>
  						<a href="ambiente.html">Educazione all'ambiente</a>
  					</li>
  					<li>
  						<a href="#biglietti">Biglietti</a>
  					</li>
  					<li>
  						<a href="#chi siamo">Chi siamo</a>
  					</li>
  					<li>
  						<a href="orario.html">Orario</a>
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
				<span>Home</span>
			</div><!-- chiudo path-->
		
		</div><!-- chiudo header-->
	
		<div id="main"><!-- div che contiene tutto il contenuto statico e/o dinamico-->
		
		<!-- !!!warning-> problemi con i label, esempio:
		
		Line 54 (63), Column 19: reference to non-existent ID "username"
		<label for="username">Username</label>
		This error can be triggered by:

		A non-existent input, select or textarea element
		A missing id attribute
		A typographical error in the id attribute
		Try to check the spelling and case of the id you are referring to. -->
			<div id="contenuto">
				<?php
				if ((! isset($_GET['iscriviti']) ) & (! isset($_POST['iscriviti']))){
				?>
				<form action="login.php" method="post">
					<fieldset>
						<label for="username">Username</label>
						<input type="text" name="username" id="username" value="<?php print $nome;?>" /><?php if ($errori['nome']>0){print $testo_errore;}?>
						<label for="passwordL">Password</label>
						<input type="password" name="password" id="passwordL" value="<?php print $password;?>" /><?php if ($errori['password']>0){print $testo_errore;}?>
						<label for="entraL">Entra</label>
						<input type="submit" name="entra" id="entraL" value="Entra" />
						<input type="hidden" name="loginF" id="loginF" value="1"/>
						<a href="login.php?iscriviti=1">Iscriviti</a>
					</fieldset>
				</form>
				<?php
				}
				else 
				{
				?>
				<form action="login.php" method="post">
					<fieldset>
						<?php
							if ($utente_gia_registrato==1) {
								?>
						<h2 class="warning">Attenzione: questa e-mail &egrave; gi&agrave; registrata!</h2>
								<?php
							}
						
						?>
						<h2>Benvenuto nuovo utente, per poterti registrare, dovresti compilare i seguenti campi:</h2>
						<label for="nome">Nome</label>
						<input type="text" name="nome" id="nome" value="<?php print $nome ?>" /><?php if ($errori['nome']>0){print $testo_errore;}?>
						<label for="cognome">Cognome</label>
						<input type="text" name="cognome" id="cognome" value="<?php print $cognome ?>" /><?php if ($errori['cognome']>0){print $testo_errore;}?>
						<label for="dataDiNascita">Data di nascita</label>
						<input type="text" name="dataDiNascita" id="dataDiNascita" value="<?php print $dataDiNascita ?>" /><?php if ($errori['dataDiNascita']>0){print $testo_errore;}?>
						<label for="email">Email</label>
						<input type="text" name="email" id="email" value="<?php print $email ?>" /><?php if ($errori['email']>0){print $testo_errore;}?>
						<label for="codice_fiscale">Codice Fiscale</label>
						<input type="text" name="codice_fiscale" id="codice_fiscale" value="<?php print $codice_fiscale ?>" /><?php if ($errori['codice_fiscale']>0){print $testo_errore;}?>
						<label for="passwordR">Password</label>
						<input type="password" name="password" id="passwordR" value="<?php print $password ?>" /><?php if ($errori['password']>0){print $testo_errore;}?>
						<label for="confermaPassword">Conferma password</label>
						<input type="password" name="confermaPassword" id="confermaPassword" value="<?php print $confermaPassword ?>" /><?php if ($errori['password']>0){print $testo_errore;}?>
						<label for="entraR">Iscriviti</label>
						<input type="submit" name="entra" id="entraR" value="Iscriviti" />
						<input type="hidden" name="iscriviti" value="1" />
					</fieldset>
				</form>
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