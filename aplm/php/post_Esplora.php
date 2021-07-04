<?php
	$conn = new mysqli("localhost", "root", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$viaggi = array();
	foreach ($_POST as $chiave => $valore) {
		array_push($viaggi, $valore);
	};
	$viaggi = array_unique($viaggi);
	$res = array();	for ($v = 0; $v < count($viaggi); $v++) {
		$q = $conn->prepare('SELECT titolo, data_partenza, data_fine, id FROM Viaggio WHERE id = ?');
		$q->bind_param('i', $viaggi[$v]);
		$q->execute();
		$q->store_result();
		$q->bind_result($titolo, $dp, $df, $id);
		$q->fetch();
		$q->free_result();
		$info = [$titolo, $dp, $df, $id];
		$luoghi = array();
		$q = $conn->prepare('SELECT longitudine, latitudine, nome FROM Luogo, Viaggio WHERE Luogo.id = luogo_partenza AND Viaggio.id = ?');
		$q->bind_param('i', $viaggi[$v]);
		$q->execute();
		$q->store_result();
		$q->bind_result($lon, $lat, $nome);
		$q->fetch();
		$q->free_result();
		$luoghi[0] = [$lon, $lat, $nome];
		$q = $conn->prepare('SELECT longitudine, latitudine, nome FROM Luogo, Tappa WHERE Luogo.id = luogo_arrivo AND viaggio = ?');
		$q->bind_param('i', $viaggi[$v]);
		$q->execute();
		$q->store_result();
		$q->bind_result($lon, $lat, $nome);
		$tottapp = $q->num_rows;
		for ($t = 0; $t < $tottapp; $t++) {
			$q->fetch();
			array_push($luoghi, [$lon, $lat, $nome]);
		};
		$q->free_result();
		array_push($res, [$info, $luoghi]);
	};
	$_POST = array();
	echo json_encode($res);
?>
