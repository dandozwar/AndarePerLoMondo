<?php
	$conn = new mysqli("localhost", "root", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$idpersona = $_POST["id"];
	$viaggi = array();
	$q = $conn->query('SELECT viaggio FROM partecipa_viaggio WHERE persona ='.$idpersona);
	$totviag = $q->num_rows;
	for ($v = 0; $v < $totviag; $v++) {
		$viag = $q->fetch_row();
		array_push($viaggi, $viag[0]);
	};
	$q->free_result();
	$res = array();
	for ($v = 0; $v < count($viaggi); $v++) {
		$q = $conn->query('SELECT titolo, data_partenza, data_fine, id, fonte, pagine FROM Viaggio WHERE id = '.$viaggi[$v]);
		$info = $q->fetch_row();
		$q->free_result();
		$luoghi = array();
		$q = $conn->query('SELECT longitudine, latitudine, nome FROM Luogo, Viaggio WHERE Luogo.id = luogo_partenza AND Viaggio.id = '.$viaggi[$v]);
		$part = $q->fetch_row();
		$q->free_result();
		$luoghi[0] = [$part[0], $part[1], $part[2]];
		$q = $conn->query('SELECT longitudine, latitudine, nome FROM Luogo, Tappa WHERE Luogo.id = luogo_arrivo AND viaggio = '.$viaggi[$v]);
		$tottapp = $q->num_rows;
		for ($t = 0; $t < $tottapp; $t++) {
			$tapp = $q->fetch_row();
			array_push($luoghi, [$tapp[0], $tapp[1], $tapp[2]]);
		};
		$q->free_result();
		array_push($res, [$info, $luoghi]);
	};
	$_POST = array();
	echo json_encode($res);
?>
