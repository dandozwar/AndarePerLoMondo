<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$tipo = $_POST['tipo'];
	$part = $_POST['partecipante'];
	$id = $_POST['id'];

	if ($tipo == 'viaggio') {
		$qgp = $conn->query('SELECT viaggio, persona FROM partecipa_viaggio WHERE viaggio ='.$id.' AND persona = '.$part);
		if ($qgp->num_rows != 0) {
			echo 'Partecipante già aggiunto.';
		} else {
			$q = $conn->prepare('INSERT INTO partecipa_viaggio (viaggio, persona) VALUES (?, ?)');
			$q->bind_param("ii", $id, $part);
			$q->execute();
			$q->store_result();
			echo 'Partecipante aggiunto.';
		};
	} else if ($tipo == 'tappa') {
		$qgp = $conn->query('SELECT tappa, persona FROM partecipa_tappa WHERE tappa ='.$id.' AND persona = '.$part);
		if ($qgp->num_rows != 0) {
			echo 'Partecipante già aggiunto.';
		} else {
			$flagPavi = false;
			$q0 = $conn->query('SELECT persona FROM partecipa_viaggio, Tappa WHERE Tappa.viaggio = partecipa_viaggio.viaggio AND Tappa.id = '.$id);
			$totpavi = $q0->num_rows;
			for ($p = 0; $p < $totpavi; $p++) {
				$pavi = $q0->fetch_row();
				if ($pavi[0] == $part) {
					$flagPavi = true;
					break;
				};
			};
			if ($flagPavi) {
				echo 'Partecipante già del viaggio.';
			} else {
				$q = $conn->prepare('INSERT INTO partecipa_tappa (tappa, persona) VALUES (?, ?)');
				$q->bind_param("ii", $id, $part);
				$q->execute();
				$q->store_result();
				echo 'Partecipante aggiunto.';
			};
		};
	};
	
?>
