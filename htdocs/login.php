<?php
	session_start();
	if (isset($_GET['logout'])) {
		session_destroy();
		session_start();
	}
	$modifica_utente=0;
	
	if(! isset($_SESSION['login'])){
		$_SESSION['login']="";
	}
	if (($_SESSION['login']!="") & (isset($_GET['area_utente']) | isset($_POST['area_utente']))){
		$modifica_utente=1;
	}
	if($modifica_utente==1){
		$_SESSION['page']="index.php?area_utente=1";
	}
	if (($_SESSION['login']!="") and ($modifica_utente==0)){
		header('Location: '.$_SERVER['REFERER'].$_SESSION['page']);
	}
	
	//include_once 'Web_service/db_aquarium.php';
	include 'database.php';
	include 'funzioniComuni.php';
	// public function __construct($id_utente_registrato, $nome, $cognome, $codice_fiscale, $data_nascita, $numero_numero_telefono, $email, $password)
   
	//$classe_utente= new Utente_registrato(0,"","","","","","","");
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
	$numero_telefono="";
	$email = "";
	
	$id_utente="";
	
	$errori=array();
	
	$errori['nome']=0;
	$errori['cognome']=0;
	$errori['dataDiNascita']=0;
	$errori['codice_fiscale']=0;
	$errori['password']=0;
	$errori['numero_telefono']=0;
	$errori['email']=0;
	
	$trovato_errori = 0;
	$utente_gia_registrato = 0;
	
	$messaggio="";
	
	
	if (isset($_POST['loginF']) & ($modifica_utente==0)) {
		/*
			eseguo il login.
		*/
		if (isset($_POST['username']) & isset($_POST['password'])){
			$nome = $_POST['username'];
			$password = $_POST['password'];
			$logged= (login(trim($nome), trim($password)));
			if ($logged==1) {
				$_SESSION['login'] = $nome;
				$page=$_SESSION['page'];
				if ($page==""){
					$page="index.html";
				}
				header('Location: '.$page);
			}else{
				$trovato_errori = 1;
				$messaggio="Errore nel login!";
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
			oppure la modifica dei dati utente
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
		if (!(isset($_POST['numero_telefono']))){
			$numero_telefono = "0123-456789";
		}
		
		/* controllo i campi */
		if (($entra=='Iscriviti') | ($modifica_utente==1)) {
			if(($modifica_utente==0) | (isset($_POST['area_utente']))){
				$nome = (isset($_POST['nome']))? $_POST['nome'] : 'Nome';
				$cognome = (isset($_POST['cognome']))? $_POST['cognome'] : 'Cogome';
				$dataDiNascita = (isset($_POST['dataDiNascita']))? $_POST['dataDiNascita'] : 'GG/MM/AAAA';
				$codice_fiscale = (isset($_POST['codice_fiscale']))? $_POST['codice_fiscale'] : 'codice_fiscale';
				$password = (isset($_POST['password']))? $_POST['password'] : 'pass';
				$confermaPassword = (isset($_POST['confermaPassword']))? $_POST['confermaPassword'] : 'word';
				$email = (isset($_POST['email']))? $_POST['email'] : 'info@example.org';
				$numero_telefono = (isset($_POST['numero_telefono']))? $_POST['numero_telefono'] : '0123-456789';
			} else {
				$dati_utente = leggi_utente();
				$nome = $dati_utente['nome'];
				$cognome = $dati_utente['cognome'];
				$dataDiNascita = $dati_utente['data_nascita'];
				$codice_fiscale = $dati_utente['codice_fiscale'];
				$numero_telefono = $dati_utente['numero_telefono'];
				$password = '';
				$confermaPassword = '';
				$email = $dati_utente['email'];
			}
			$risultato_regex="";
			preg_match("/[a-zA-Z\s]+/", $nome, $risultato_regex);
			if ($risultato_regex[0]!=$nome) {
				$errori['nome']=1;
				$trovato_errori = 1;
			}
			$risultato_regex="";
			if (controlla_data($dataDiNascita)==0) {
					$errori['dataDiNascita']=1;
					$trovato_errori = 1;
					
			}else {
					$dataDiNascita = str_replace('/','-', $dataDiNascita);
					$date = new DateTime(converti_data($dataDiNascita));
					$now = new DateTime();
					$date->modify('+18 year');
					if ($date>$now){
						$errori['dataDiNascita']=1;
						$trovato_errori = 1;
					}
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
			if($email!="admin"){
				preg_match("/[a-zA-Z\.0-9]+@[a-zA-Z\.0-9]+\.[a-zA-Z\.0-9]+/", $email, $risultato_regex);
				if (!isset($risultato_regex[0])) {
					$errori['email']=1;
					$trovato_errori = 1;
				}else{
					if($risultato_regex[0]!=$email){
						$errori['email']=1;
						$trovato_errori = 1;
					}	
				}
			}
			
			if ($password != $confermaPassword){
				$errori['password']=1;
				$trovato_errori = 1;
			}
			if ($trovato_errori==0){
				
				if($modifica_utente==0){
					$utente_gia_registrato=registraUtente($nome, $cognome, $dataDiNascita, $email, $codice_fiscale, $password, $numero_telefono);
				
					if ($utente_gia_registrato == 2 ){
						$logged= (login($email, $password));
						if ($logged==1) {
							$_SESSION['login'] = $nome;
							header('Location: '.$_SERVER['REFERER'].'/index.html');
						}else{
							$trovato_errori = 1;
						}
					}else{
						$messaggio="Utente gi&agrave; registrato!";
					}
				}else{
					/* se sto per modificare*/
					if(isset($_POST['area_utente'])){
						if ($password=="" | $confermaPassword==""){
							$password="";
						}
						$res_aggiornamento=aggiorna_utente($nome, $cognome, $dataDiNascita, $email, $codice_fiscale, $password, $numero_telefono);
						if($res_aggiornamento==2){
							$messaggio="Dati modificati correttamente.";
						}else{
							$messaggio="C'&egrave; stato un problema nella modifica dei dati personali!";
						}
					}else{
						$messaggio.='<p><a href="pagina_prenotazioni.php" class="link_form">Gestisci le prenotazioni</a></p>';
					
					}
				}
			}
		}
	}
	stampa_head('Login', "Pagina utente");
?>
			<div id="content">
				<?php
				
				if ((! isset($_GET['iscriviti']) ) & (! isset($_POST['iscriviti'])) & ($modifica_utente==0)){
				?>
				<form action="login.php" method="post">
					<fieldset>
						<div>
							<label for="username">Username</label>
							<input type="text" name="username" id="username" value="<?php print $nome;?>" /><?php if ($errori['nome']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="passwordL">Password</label>
							<input type="password" name="password" id="passwordL" value="<?php print $password;?>" /><?php if ($errori['password']>0){print $testo_errore;}?>
						</div>
						<label for="entraL">Entra</label>
						<input type="submit" name="entra" id="entraL" value="Entra" />
						<input type="hidden" name="loginF" id="loginF" value="1"/>
						<p><a href="login.php?iscriviti=1">Non sei registrato? Iscriviti!</a></p>
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
						
						if($modifica_utente==0){
						?>
						<h2>Benvenuto nuovo utente, per poterti registrare, dovresti compilare i seguenti campi:</h2>
						<?php
						}else{
						?>
						<h2>Benvenuto nella tua area personale; qui puoi aggiornare i tuoi dati.</h2>
						<a href="login.php?logout=1">Esegui il logout</a>
						<?php
						}
						
						?>
						<div>
							<label for="nome">Nome</label>
							<input type="text" name="nome" id="nome" value="<?php print $nome ?>" /><?php if ($errori['nome']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="cognome">Cognome</label>
							<input type="text" name="cognome" id="cognome" value="<?php print $cognome ?>" /><?php if ($errori['cognome']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="dataDiNascita">Data di nascita</label>
							<input type="text" name="dataDiNascita" id="dataDiNascita" value="<?php print $dataDiNascita ?>" /><?php if ($errori['dataDiNascita']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="email">Email (non modificabile dopo la registrazione)</label>
							<input type="text" readonly="readonly" name="email" id="email" value="<?php print $email ?>" /><?php if ($errori['email']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="codice_fiscale">Codice Fiscale</label>
							<input type="text" name="codice_fiscale" id="codice_fiscale" value="<?php print $codice_fiscale; ?>" /><?php if ($errori['codice_fiscale']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="numero_telefono">Numero di telefono</label>
							<input type="text" name="numero_telefono" id="numero_telefono" value="<?php print $numero_telefono; ?>" /><?php if($errori['numero_telefono']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="passwordR">Password</label>
							<input type="password" name="password" id="passwordR" value="<?php print $password ?>" /><?php if ($errori['password']>0){print $testo_errore;}?>
						</div>
						<div>
							<label for="confermaPassword">Conferma password</label>
							<input type="password" name="confermaPassword" id="confermaPassword" value="<?php print $confermaPassword ?>" /><?php if ($errori['password']>0){print $testo_errore;}?>
						</div>
						<?php
						$txt_pulsante = "Iscriviti";
						if($modifica_utente==1){
							$txt_pulsante="Aggiorna i tuoi dati";
							print '<input type="hidden" id="area_utente" name="area_utente" value="1"/>';
						}
						print "<label for=\"entraR\">$txt_pulsante</label>";
						print "<input type=\"submit\" name=\"entra\" id=\"entraR\" value=\"$txt_pulsante\" />";
						?>
						<input type="hidden" name="iscriviti" value="1" />
					</fieldset>
				</form>
				<?php
				}
				if($trovato_errori>0){
					print "<h2>Errore, compila i campi indicati correttamente.</h2>";
				}
				if ($messaggio!=""){
					print "<h2>$messaggio</h2>";
				}
				?>
			</div><!-- chiudo contenuto-->

<?php
		stampa_footer();
?>