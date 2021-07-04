<?php
	$conn = new mysqli("localhost", "root", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$biografie = array();
	$q = $conn->query('SELECT id, persona FROM Biografia');
	$totbiog = $q->num_rows;
	for ($b = 0; $b < $totbiog; $b++){
		$biog = $q->fetch_row();
		array_push($biografie, [$biog[0], $biog[1]]);
	};
	$q->free_result();
	$res = array();
	for ($b = 0; $b < count($biografie); $b++) {
		$q = $conn->query('SELECT viaggio1 AS viaggio FROM Biografia WHERE persona = '.$biografie[$b][1].' UNION SELECT viaggio2 AS viaggio FROM Biografia WHERE persona = '.$biografie[$b][1]);
		$totviag = $q->num_rows;
		$luoghi = array();
		for ($v = 0; $v < $totviag; $v++) {
			$viag = $q->fetch_row();
			if ($viag[0] != NULL) {
				$q2 = $conn->query('SELECT longitudine, latitudine, Luogo.nome FROM Luogo, Viaggio WHERE Luogo.id = Viaggio.luogo_partenza AND Viaggio.id = '.$viag[0]);
				$part = $q2->fetch_row();
				$q2->free_result();
				array_push($luoghi, [$part[0], $part[1], $part[2]]);
				$q2 = $conn->query('SELECT longitudine, latitudine, Luogo.nome FROM Luogo, Tappa WHERE Luogo.id = Tappa.luogo_arrivo AND Tappa.viaggio = '.$viag[0]);
				$tottapp = $q2->num_rows;
				for ($t = 0; $t < $tottapp; $t++) {
					$tapp = $q2->fetch_row();
					array_push($luoghi, [$tapp[0], $tapp[1], $tapp[2]]);
				};
				$q2->free_result();
			};
		};
		$q->free_result();
		array_push($res, [$biografie[$b], $luoghi]);
	};
	$_POST = array();
	echo json_encode($res);
?>
