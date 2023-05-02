<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$dest = $_POST['destinatario'];
	$id = $_POST['id'];

	$qgp = $conn->query('SELECT scopo, persona FROM destinatario WHERE scopo ='.$id.' AND persona = '.$dest);
	if ($qgp->num_rows != 0) {
		echo 'Destinatario già aggiunto.';
	} else {
		$q = $conn->prepare('INSERT INTO destinatario (scopo, persona) VALUES (?, ?)');
		$q->bind_param("ii", $id, $dest);
		$q->execute();
		$q->store_result();
		echo 'Destinatario aggiunto.';
	};
	
?>
