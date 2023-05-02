<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$errori = array();
	$tipo = $_POST['tipo'];
	$scop = $_POST['scopo'];
	$id = $_POST['id'];

	if ($tipo == 'viaggio') {
		$q = $conn->query('SELECT scopo, viaggio FROM motivo_viaggio WHERE persona = '.$scop.' AND viaggio = '.$id);
		if ($q->num_rows == 0) {
			echo 'Motivo viaggio già eliminato.';
		} else {
			$res = $q->fetch_row();
			$q2 = $conn->prepare('DELETE FROM motivo_viaggio WHERE scopo = ? AND viaggio = ?');
			$q2->bind_param("ii", $scop, $id);
			$q2->execute();
			$q2->store_result();
			$q2->free_result();
			echo 'Motivo viaggio eliminato.';
		};
	} else if ($tipo == 'tappa') {
		$q = $conn->query('SELECT scopo, tappa FROM motivo_tappa WHERE scopo = '.$scop.' AND tappa = '.$id);
		if ($q->num_rows == 0) {
			echo 'Motivo tappa già eliminato.';
		} else {
			$res = $q->fetch_row();
			$q2 = $conn->prepare('DELETE FROM motivo_tappa WHERE scopo = ? AND tappa = ?');
			$q2->bind_param("ii", $scop, $id);
			$q2->execute();
			$q2->store_result();
			$q2->free_result();
			echo 'Motivo tappa eliminato.';
		};
	};
	$q->free_result();
?>
