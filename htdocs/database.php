<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	/*
		questo file contiene i riferimenti al DB
	*/
	$host_db="127.0.0.1";
	$nome_utente_db="tecweb";
	$password_utente_db="tecweb";
	$nome_db="tecweb";
	


	/*
		per la crittografia della password
	*/

	function generaPSW($password, $username){
		$res=hash_pbkdf2("sha256", $password, $username, 50, 50);
		return $res;
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
		if ($stmt = mysqli_prepare($oggetto_db, 'SELECT email FROM Utente_Registrato WHERE email = ? AND password = ? ')){
			$psw2= generaPSW($password, $username);
   			mysqli_stmt_bind_param($stmt, "ss", $username, $psw2);
    		mysqli_stmt_execute($stmt);
    		mysqli_stmt_bind_result($stmt, $ema);
    		mysqli_stmt_fetch($stmt);
    		
  			if ($username == $ema) {
  				$trovato = 1;
  			}
  			
    		mysqli_stmt_close($stmt);
		}
		mysqli_close($oggetto_db);
		
		return $trovato;
	}
	
	function registraUtente($nome, $cognome, $data_di_nascita, $email, $codice_fiscale, $password) {
		global $host_db;
		global $nome_utente_db;
		global $password_utente_db;
		global $nome_db;
		
		$oggetto_db = mysqli_connect($host_db, $nome_utente_db, $password_utente_db, $nome_db);
		
		print "1";
		
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
			print ".";
			return 1;
		}
		if ($stmt = mysqli_prepare($oggetto_db, 'INSERT INTO Utente_Registrato (nome, cognome, codice_fiscale, data_nascita, email, password) values (?, ?, ?, ?, ?, ?)')){
			$psw2= generaPSW($password, $email);
   			mysqli_stmt_bind_param($stmt, "ssssss", $nome, $cognome, $codice_fiscale, $data_di_nascita, $email,$psw2 );
    		mysqli_stmt_execute($stmt);
  			
    		mysqli_stmt_close($stmt);
		}
		mysqli_close($oggetto_db);
		
		return 2;
	} 
?>