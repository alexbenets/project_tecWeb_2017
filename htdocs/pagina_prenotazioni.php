<?php 
	session_start();
	require "database.php";
	require "funzioniComuni.php";
		
	if(!isset($_SESSION['login'])){
		$_SESSION['login']="";
	}
	/* questa pagina non dev'essere consultabile se non si è loggati.  */
	if ($_SESSION['login']==""){
		$_SESSION['page']="index.html";
		header('Location: '.$_SERVER['REFERER'].$_SESSION['page']);
		exit;
	}
	
	stampa_head('Gestione prenotazioni', "Biglietti");
?>
	<div id="content">
		<h2>Benvenuto nel pannello di gestione delle prenotazioni!</h2>
	
	</div>
	<!-- chiudo content-->
			
<?php
	stampa_footer();

?>