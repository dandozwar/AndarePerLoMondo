<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$id = $_POST['id'];
	$campo = $_POST['campo'];
	$valore = $_POST['valore'];
	$tipo = $_POST['tipo'];
	
	$q1 = $conn->query('SELECT * FROM relazione WHERE id = '.$id);
	$rela = $q1->fetch_row();
	switch ($campo) {
		case 'persona2':
			$rela[2] = $valore;
			break;
		case 'tipo':
			$rela[3] = $valore;
			break;
		case 'data_inizio':
			if ($tipo != 'intervallo') {
				$rela[4] = $valore;
			} else {
				$rela[6] = $valore;
			};
			break;
		case 'data_fine':
			if ($tipo != 'intervallo') {
				$rela[5] = $valore;
			} else {
				$rela[7] = $valore;
			};
			break;
		default:
			echo 'Errore!';
			break;
	};
	$query_string2 = 'SELECT COUNT(*) FROM relazione WHERE persona1 = ? AND persona2 = ? AND tipo = ? AND data_inizio = ? AND data_fine = ? AND intervallo_inizio = ? AND intervallo_fine = ?';
	$q2 = $conn->prepare($query_string2);
	$q2->bind_param("iiissii", $rela[1], $rela[2], $rela[3], $rela[4], $rela[5], $rela[6], $rela[7]);
	$q2->execute();
	$q2->store_result();
	$q2->bind_result($totale);
	$q2->fetch();
	if ($totale == 0) {
		if ($campo == 'data_inizio' || $campo == 'data_fine') {
			if ($tipo != 'intervallo') {
				if ($campo == 'data_inizio') {
					$qd = $conn->prepare('UPDATE relazione SET intervallo_inizio = NULL, data_inizio = ? WHERE id = ?');
					$qd->bind_param("si", $valore, $id);
					$qd->execute();
				} else if ($campo == 'data_fine') {
					$qd = $conn->prepare('UPDATE relazione SET intervallo_fine = NULL, data_fine = ? WHERE id = ?');
					$qd->bind_param("si", $valore, $id);
					$qd->execute();
				};
			} else {
				if ($campo == 'data_inizio') {
					$qd = $conn->prepare('UPDATE relazione SET intervallo_inizio = ?, data_inizio = NULL WHERE id = ?');
					$qd->bind_param("si", $valore, $id);
					$qd->execute();
				} else if ($campo == 'data_fine') {
					$qd = $conn->prepare('UPDATE relazione SET intervallo_fine = ?, data_fine = NULL WHERE id = ?');
					$qd->bind_param("ii", $valore, $id);
					$qd->execute();
				};
			};
		} else {
			$query_string3 = 'UPDATE relazione SET '.$campo.' = ? WHERE id = ?';
			$q3 = $conn->prepare($query_string3);
			$q3->bind_param("si", $valore, $id);
			$q3->execute();
		};
		echo 'Modifica effettuata.';
	} else {
		echo 'Relazione già presente nel database.';
	};	
?>
