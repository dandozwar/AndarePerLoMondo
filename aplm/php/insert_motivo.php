<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$tipo = $_POST['tipo'];
	$scop = $_POST['scopo'];
	$id = $_POST['id'];

	if ($tipo == 'viaggio') {
		$qgp = $conn->query('SELECT viaggio, scopo FROM motivo_viaggio WHERE viaggio ='.$id.' AND scopo = '.$scop);
		if ($qgp->num_rows != 0) {
			echo 'Motivo già aggiunto.';
		} else {
			$q = $conn->prepare('INSERT INTO motivo_viaggio (viaggio, scopo) VALUES (?, ?)');
			$q->bind_param("ii", $id, $scop);
			$q->execute();
			$q->store_result();
			echo 'Motivo aggiunto.';
		};
	} else if ($tipo == 'tappa') {
		$qgp = $conn->query('SELECT tappa, scopo FROM motivo_tappa WHERE tappa ='.$id.' AND scopo = '.$scop);
		if ($qgp->num_rows != 0) {
			echo 'Motivo già aggiunto.';
		} else {
			$q = $conn->prepare('INSERT INTO motivo_tappa (tappa, scopo) VALUES (?, ?)');
			$q->bind_param("ii", $id, $scop);
			$q->execute();
			$q->store_result();
			echo 'Motivo aggiunto.';
		};
	};
	
?>
