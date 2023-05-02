<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$viaggio = $_POST['id'];
	$campo = $_POST['campo'];
	$valore = $_POST['valore'];
	$messaggio;
	
	if ($campo == 'titolo') {
		$q = $conn->prepare('SELECT titolo FROM Viaggio WHERE titolo = ?');
		$q->bind_param("s", $valore);
		$q->execute();
		$q->store_result();
		if ($q->num_rows() == 0) {
			$qt = $conn->prepare('UPDATE Viaggio SET titolo = ? WHERE id = ?');
			$qt->bind_param("si", $valore, $viaggio);
			$qt->execute();
			$messaggio = 'Modifica effettuata.';
		} else {
			$messaggio = 'Titolo già presente.';
		};
	} else if ($campo == 'data_partenza' || $campo == 'data_fine') {
		$tipo = $_POST['tipo'];
		if ($tipo != 'intervallo') {
			if ($campo == 'data_partenza') {
				$qd = $conn->prepare('UPDATE Viaggio SET intervallo_partenza = NULL, data_partenza = ? WHERE id = ?');
				$qd->bind_param("si", $valore, $viaggio);
				$qd->execute();
				$messaggio = 'Modifica effettuata.';
			} else if ($campo == 'data_fine') {
				$qd = $conn->prepare('UPDATE Viaggio SET intervallo_fine = NULL, data_fine = ?  WHERE id = ?');
				$qd->bind_param("si", $valore, $viaggio);
				$qd->execute();
				$messaggio = 'Modifica effettuata.';
			};
		} else {
			if ($campo == 'data_partenza') {
				$qd = $conn->prepare('UPDATE Viaggio SET intervallo_partenza = ?, data_partenza = NULL WHERE id = ?');
				$qd->bind_param("si", $valore, $viaggio);
				$qd->execute();
				$messaggio = 'Modifica effettuata.';
			} else if ($campo == 'data_fine') {
				$qd = $conn->prepare('UPDATE Viaggio SET intervallo_fine = ?, data_fine = NULL  WHERE id = ?');
				$qd->bind_param("si", $valore, $viaggio);
				$qd->execute();
				$messaggio = 'Modifica effettuata.';
			};
		};
	} else {
		$query_string = 'UPDATE Viaggio SET '.$campo.' = ? WHERE id = ?';
		$q = $conn->prepare($query_string);
		$q->bind_param("si", $valore, $viaggio);
		$q->execute();
		$messaggio = 'Modifica effettuata.';
	};
	echo $messaggio;
?>
