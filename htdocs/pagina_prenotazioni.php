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
	
	$amministratore=-1;
	if(isset($_SESSION['admin'])){
		if($_SESSION['admin']==$_SESSION['userID']){
			$amministratore=$_SESSION['userID'];
		}
	}
	
	/* sezione per l'eliminazione di una prenotazione 
		1: 	controllo se esistono i campi
	*/
	/* provvedo ad eliminare la prenotazione desiderata */
	$res=0;
	$id_eliminazione=0;
	if($amministratore>0){
		if(isset($_GET['elimina'])){
			$id_eliminazione=$_GET['elimina'];
			if($id_eliminazione>0){
				$res=rimuovi_prenotazione($id_eliminazione);
			}
		}	
	}
	
	
	stampa_head('Gestione prenotazioni', "Pagina utente");
?>
	<div id="content">
		<h2>Benvenuto nel pannello di gestione delle prenotazioni!</h2>
		<?php
		
		if ($amministratore<0){
			print "<h3>Puoi solo visualizzare le tue prenotazioni.</h3>";
		}else{
			print "<h3>Puoi eliminare le prenotazioni.</h3>";
		}
		
		$testo="";
		$prenotazioni=leggi_prenotazioni($_SESSION['userID']);
		if($id_eliminazione>0){
			//$res
			if($res==2){
				print "<h2>Prenotazione n&deg; $id_eliminazione CANCELLATA</h2>";
			}else{
				print "<h2>Errore nella cancellazione della prenotazione n&deg; $id_eliminazione .</h2>";
			}
		}
		?>
		<table class="tabella_alto_contrasto">
			<tr>
				<th>Numero prenotazione</th>
				<th>Data prenotata</th>
				<th>Descrizione</th>
				<th>Posti</th>
				<th>Prezzo unitario</th>
				<?php
					if ($amministratore>0){
						print "<th>Rimuovi</th>";
					}
				?>
			</tr>
		<?php
			foreach ($prenotazioni as &$riga ){
				print "<tr>";
				print "<td>".$riga['ID']."</td>";
				print "<td>".decodifica_data($riga['data']).'</td>';
				print "<td>".$riga['nome']." ".$riga['descrizione']."</td>";
				print "<td>".$riga['numero_posti']."</td>";
				if($riga['prezzo']>0){
					print "<td>".$riga['prezzo']." &euro;</td>";
				}else{
					print "<td>GRATIS</td>";
				}
				if ($amministratore>0){
						print '<td><a href="pagina_prenotazioni.php?elimina='.$riga['ID'].'">Rimuovi</a></td>';
				}
				print $testo.'</tr>';
			}
		?>
		</table>
		<?php
		
		if ($amministratore<0){
			print "<h3>Per annullare una prenotazione &egrave; necessario contattarci.</h3>";
		}
		
		?>
	</div>
	<!-- chiudo content-->
			
<?php
	stampa_footer();

?>