<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$tappa = $_POST['id'];
	$campo = $_POST['campo'];
	$valore = $_POST['valore'];
	
	if ($campo == 'data_partenza' || $campo == 'data_arrivo') {
		$tipo = $_POST['tipo'];
		if ($tipo != 'intervallo') {
			if ($campo == 'data_partenza') {
				$qd = $conn->prepare('UPDATE Tappa SET intervallo_partenza = NULL, data_partenza = ? WHERE id = ?');
				$qd->bind_param("si", $valore, $tappa);
				$qd->execute();
			} else if ($campo == 'data_arrivo') {
				$qd = $conn->prepare('UPDATE Tappa SET intervallo_arrivo = NULL, data_arrivo = ?  WHERE id = ?');
				$qd->bind_param("si", $valore, $tappa);
				$qd->execute();
			};
		} else {
			if ($campo == 'data_partenza') {
				$qd = $conn->prepare('UPDATE Tappa SET intervallo_partenza = ?, data_partenza = NULL WHERE id = ?');
				$qd->bind_param("si", $valore, $tappa);
				$qd->execute();
			} else if ($campo == 'data_arrivo') {
				$qd = $conn->prepare('UPDATE Tappa SET intervallo_arrivo = ?, data_arrivo = NULL  WHERE id = ?');
				$qd->bind_param("si", $valore, $tappa);
				$qd->execute();
			};
		};
	} else {
		$query_string = 'UPDATE Tappa SET '.$campo.' = ? WHERE id = ?';
		$q = $conn->prepare($query_string);
		$q->bind_param("si", $valore, $tappa);
		$q->execute();
	};
	echo 'Modifica effettuata.';
?>
