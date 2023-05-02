<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$persona = $_POST['id'];
	$campo = $_POST['campo'];
	$valore = $_POST['valore'];
	
	if ($campo == 'data_nascita' || $campo == 'data_morte') {
		$tipo = $_POST['tipo'];
		if ($tipo != 'intervallo') {
			if ($campo == 'data_nascita') {
				$qd = $conn->prepare('UPDATE Persona SET intervallo_nascita = NULL, data_nascita = ? WHERE id = ?');
				$qd->bind_param("si", $valore, $persona);
				$qd->execute();
			} else if ($campo == 'data_morte') {
				$qd = $conn->prepare('UPDATE Persona SET intervallo_morte = NULL, data_morte = ?  WHERE id = ?');
				$qd->bind_param("si", $valore, $persona);
				$qd->execute();
			};
		} else {
			if ($campo == 'data_nascita') {
				$qd = $conn->prepare('UPDATE Persona SET intervallo_nascita = ?, data_nascita = NULL WHERE id = ?');
				$qd->bind_param("si", $valore, $persona);
				$qd->execute();
			} else if ($campo == 'data_morte') {
				$qd = $conn->prepare('UPDATE Persona SET intervallo_morte = ?, data_morte = NULL  WHERE id = ?');
				$qd->bind_param("si", $valore, $persona);
				$qd->execute();
			};
		};
	} else {
		$query_string = 'UPDATE Persona SET '.$campo.' = ? WHERE id = ?';
		$q = $conn->prepare($query_string);
		$q->bind_param("si", $valore, $persona);
		$q->execute();
	};
	echo 'Modifica effettuata.';
?>
