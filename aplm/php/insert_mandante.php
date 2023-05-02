<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$mand = $_POST['mandante'];
	$id = $_POST['id'];

	$qgp = $conn->query('SELECT scopo, persona FROM mandante WHERE scopo ='.$id.' AND persona = '.$mand);
	if ($qgp->num_rows != 0) {
		echo 'Mandante già aggiunto.';
	} else {
		$q = $conn->prepare('INSERT INTO mandante (scopo, persona) VALUES (?, ?)');
		$q->bind_param("ii", $id, $mand);
		$q->execute();
		$q->store_result();
		echo 'Mandante aggiunto.';
	};
	
?>
