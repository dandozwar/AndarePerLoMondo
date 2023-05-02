<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$persona = $_POST['persona'];
	$campo = $_POST['campo'];
	$valore = $_POST['valore'];
	
	$q0 = $conn->query('SELECT id FROM Biografia WHERE persona = '.$persona);
	$arr_bio = $q0->fetch_row();
	$id_bio = $arr_bio[0];

	if ($campo == 'viaggio1' || $campo == 'viaggio2') {
		if ($campo == 'viaggio1') {
			$q1 = $conn->query('SELECT viaggio2 FROM Biografia WHERE persona ='.$persona);
			$check_v2 = $q1->fetch_row();
			if ($check_v2[0] != $valore) {
				$query_string = 'UPDATE Biografia SET '.$campo.' = ? WHERE id = ?';
				$q = $conn->prepare($query_string);
				$q->bind_param("si", $valore, $id_bio);
				$q->execute();
				echo 'Modifica effettuata.';
			} else {
				echo 'Viaggio 1 e Viaggio 2 sono uguali.';
			};
		} else if ($campo == 'viaggio2') {
			$q1 = $conn->query('SELECT viaggio1 FROM Biografia WHERE persona ='.$persona);
			$check_v1 = $q1->fetch_row();
			if ($check_v1[0] != $valore) {
				$query_string = 'UPDATE Biografia SET '.$campo.' = ? WHERE id = ?';
				$q = $conn->prepare($query_string);
				$q->bind_param("si", $valore, $id_bio);
				$q->execute();
				echo 'Modifica effettuata.';
			} else {
				echo 'Viaggio 1 e Viaggio 2 sono uguali.';
			};
		};
	} else {
		$query_string = 'UPDATE Biografia SET '.$campo.' = ? WHERE id = ?';
		$q = $conn->prepare($query_string);
		$q->bind_param("si", $valore, $id_bio);
		$q->execute();
		echo 'Modifica effettuata.';
	};
?>
