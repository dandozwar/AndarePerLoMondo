<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$errori = array();
	$tipo = $_POST['tipo'];
	$pers = $_POST['partecipante'];
	$id = $_POST['id'];

	if ($tipo == 'viaggio') {
		$q = $conn->query('SELECT persona, viaggio FROM partecipa_viaggio WHERE persona = '.$pers.' AND viaggio = '.$id);
		if ($q->num_rows == 0) {
			echo 'Partecipante già eliminato.';
		} else {
			$res = $q->fetch_row();
			$q2 = $conn->prepare('DELETE FROM partecipa_viaggio WHERE persona = ? AND viaggio = ?');
			$q2->bind_param("ii", $pers, $id);
			$q2->execute();
			$q2->store_result();
			$q2->free_result();
			echo 'Partecipante eliminato.';
		};
	} else if ($tipo == 'tappa') {
		$q = $conn->query('SELECT persona, tappa FROM partecipa_tappa WHERE persona = '.$pers.' AND tappa = '.$id);
		if ($q->num_rows == 0) {
			echo 'Partecipante già eliminato.';
		} else {
			$res = $q->fetch_row();
			$q2 = $conn->prepare('DELETE FROM partecipa_tappa WHERE persona = ? AND tappa = ?');
			$q2->bind_param("ii", $pers, $id);
			$q2->execute();
			$q2->store_result();
			$q2->free_result();
			echo 'Partecipante eliminato.';
		};
	};
	$q->free_result();
?>
