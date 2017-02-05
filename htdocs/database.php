<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	/*
		questo file contiene i riferimenti al DB
	*/
	$host_db="127.0.0.1";
	$nome_utente_db="mmorra";
	$password_utente_db="yieSeeja9sha3eeg";
	$nome_db="mmorra";
	


	/*
		per la crittografia della password
	*/

	function generaPSW($password, $username){
		$res=hash_pbkdf2("sha256", $password, $username, 50, 50);
		return $res;
	}
	
	function converti_data($data){
		return str_replace('/','-', $data);
	}
	
	function decodifica_data($data){
		return str_replace('-','/', $data);
	
	}

	function controlla_data($data){
		preg_match("/[0-9]{4}\/[0-9]{2}\/[0-9]{2}/", $data, $risultato_regex);
		if ($risultato_regex != null){
			if ($risultato_regex[0]==$data) {
				return 1;
			}
		}
		preg_match("/[0-9]{4}-[0-9]{2}-[0-9]{2}/", $data, $risultato_regex);
		if ($risultato_regex != null){
			if ($risultato_regex[0]==$data) {
				return 1;
			}
		}
		return 0;
	}

	/* eseguo il login, restituisco True se il login è ok */
	function login($username, $password) {
		
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		$trovato = 0;
		
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		if ($stmt = mysqli_prepare($oggetto_db, 'SELECT u.email, u.ID_Utente_Registrato, IFNULL(adm.ID_Utente_Registrato, 0) as id_adm FROM mmorra.Utente_Registrato u left join mmorra.Amministratore adm on u.ID_Utente_Registrato=adm.ID_Utente_Registrato WHERE email = ? AND password = ? ')){
			$psw2= generaPSW($password, $username);
   			mysqli_stmt_bind_param($stmt, "ss", $username, $psw2);
    		mysqli_stmt_execute($stmt);
    		mysqli_stmt_bind_result($stmt, $ema, $id_reg, $amm);
    		mysqli_stmt_fetch($stmt);
  			if ($username == $ema) {
  				$trovato = 1;
  				$_SESSION['userID']= $id_reg;
  				$_SESSION['admin']= $amm;
  				$_SESSION['email']=$ema;
  			}
  			
    		mysqli_stmt_close($stmt);
		}
		mysqli_close($oggetto_db);
		
		return $trovato;
	}
	
	function leggi_utente(){
	
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		
		$risultato=array();
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		$query = 'SELECT * FROM Utente_Registrato WHERE ID_Utente_Registrato = '.$_SESSION['userID'];
		if ($result = mysqli_query($oggetto_db, $query)) {
 			/* fetch associative array */
			$risultato = mysqli_fetch_assoc($result);
		    /* free result set */
		    mysqli_free_result($result);
		}

		mysqli_close($oggetto_db);
		
		return $risultato;
	}
	
	function registraUtente($nome, $cognome, $data_di_nascita, $email, $codice_fiscale, $password, $telefono) {
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		
		$trovato = 0;
		
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		if ($stmt = mysqli_prepare($oggetto_db, 'SELECT email FROM Utente_Registrato WHERE email = ?')){
   			mysqli_stmt_bind_param($stmt, "s", $email);
    		mysqli_stmt_execute($stmt);
    		mysqli_stmt_bind_result($stmt, $ema);
    		mysqli_stmt_fetch($stmt);
    		
  			if ($email == $ema) {
  				$trovato = 1;
  			}
  			
    		mysqli_stmt_close($stmt);
		}
		if ($trovato==1 ){
			return 1;
		}
		if ($stmt = mysqli_prepare($oggetto_db, 'INSERT INTO Utente_Registrato (nome, cognome, codice_fiscale, data_nascita, email, password, numero_telefono) values (?, ?, ?, ?, ?, ?, ?)')){
			$psw2= generaPSW($password, $email);
   			mysqli_stmt_bind_param($stmt, "sssssss", $nome, $cognome, $codice_fiscale, $data_di_nascita, $email,$psw2,$telefono );
    		mysqli_stmt_execute($stmt);
  			
    		mysqli_stmt_close($stmt);
		}
		mysqli_close($oggetto_db);
		
		return 2;
	} 
	
	function aggiorna_utente($nome, $cognome, $data_di_nascita, $email, $codice_fiscale, $password, $numero_telefono){
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		

		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		$ema=$_SESSION['email'];
		
		$trovato = 0;
		$psw2="";
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		if ($stmt = mysqli_prepare($oggetto_db, 'SELECT password FROM Utente_Registrato WHERE ID_Utente_Registrato = ?')){
   			mysqli_stmt_bind_param($stmt, "i", $_SESSION['userID']);
    		mysqli_stmt_execute($stmt);
    		mysqli_stmt_bind_result($stmt, $psw2);
    		mysqli_stmt_fetch($stmt);
    		
  			
    		mysqli_stmt_close($stmt);
		}
		
		if ($stmt = mysqli_prepare($oggetto_db, 'UPDATE Utente_Registrato SET nome = ?, cognome = ?, codice_fiscale = ?, data_nascita = ?, email = ?, password = ?, numero_telefono = ?  WHERE ID_Utente_Registrato = ?')){
			if($password!=""){
				$psw2= generaPSW($password, $email);
			}
			mysqli_stmt_bind_param($stmt, "sssssssi", $nome, $cognome, $codice_fiscale, $data_di_nascita, $ema,$psw2, $numero_telefono, $_SESSION['userID']);
    		mysqli_stmt_execute($stmt);
    		mysqli_stmt_close($stmt);
		}else{
				return 0;
		}
		mysqli_close($oggetto_db);
		
		return 2;
	}
	
	function prenota($data, $posti, $tipo_prenotazione, $id_utente){
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		$trovato = 1;
		
		$data_convertita = converti_data($data);
		
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		if ($stmt = mysqli_prepare($oggetto_db, 'INSERT INTO Prenotazione (data, numero_posti, ID_Sede, ID_Tipologia_prenotazione, ID_Utente_registrato) values (?, ?, ?, ?, ?)')){
			mysqli_stmt_bind_param($stmt, "siiii",  $data_convertita, $posti, $trovato, $tipo_prenotazione, $id_utente);
			mysqli_stmt_execute($stmt);
  			
  			/* se ho eseguito l'insert */
    		if(mysqli_stmt_affected_rows ($stmt)==1){
    			$trovato = 2;
    		}
    		mysqli_stmt_close($stmt);
		}
		mysqli_close($oggetto_db);
		
		return $trovato;
	}
	
	function leggi_tipologie_di_prenotazione(){
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		$risultato=array();
		
		$trovato = 1;
		
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		$query = "SELECT * FROM Tipologia_Prenotazione order by note_varie desc";
		
		if ($result = mysqli_query($oggetto_db, $query)) {
 			/* fetch associative array */
			while ($row = mysqli_fetch_assoc($result)) {
		        array_push($risultato, $row);
		    }

		    /* free result set */
		    mysqli_free_result($result);
		}

		mysqli_close($oggetto_db);
		
		return $risultato;
	}
	
	function leggi_prenotazioni($id_utente){
		$sql="	SELECT ID_Prenotazione as ID, data, numero_posti, nome, descrizione, prezzo FROM 
				mmorra.Prenotazione prenotazione 
				inner join mmorra.Tipologia_Prenotazione tipo 
				on prenotazione.ID_Tipologia_Prenotazione=tipo.ID_Tipologia_Prenotazione";
		if($id_utente>0){
			$sql.=	" where ID_Utente_Registrato = ".$id_utente;
		}		
		$sql.=	" order by data desc LIMIT 1000";
		
		
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		$risultato=array();
		
		$trovato = 1;
		
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		
		
		if ($result = mysqli_query($oggetto_db, $sql)) {
 			/* fetch associative array */
			while ($row = mysqli_fetch_assoc($result)) {
		        array_push($risultato, $row);
		    }

		    /* free result set */
		    mysqli_free_result($result);
		}

		mysqli_close($oggetto_db);
		
		return $risultato;
	}
	
	function rimuovi_prenotazione($id_prenotazione){
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		$trovato = 1;
		
		if (mysqli_connect_errno()) {
    		printf("Connect failed: %s\n", mysqli_connect_error());
			return -1;
		}
		if ($stmt = mysqli_prepare($oggetto_db, 'DELETE FROM Prenotazione WHERE ID_Prenotazione = ?')){
			mysqli_stmt_bind_param($stmt, "i",  $id_prenotazione);
			mysqli_stmt_execute($stmt);
  			
  			/* se ho eseguito l'insert */
    		if(mysqli_stmt_affected_rows ($stmt)==1){
    			$trovato = 2;
    		}
    		mysqli_stmt_close($stmt);
		}
		mysqli_close($oggetto_db);
		
		return $trovato;
	}
?>