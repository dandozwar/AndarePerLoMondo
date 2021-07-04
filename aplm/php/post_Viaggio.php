<?php
	$conn = new mysqli("localhost", "root", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$id = $_POST["id"];
	$arr = array();
	$q = $conn->query('SELECT longitudine, latitudine, Luogo.nome FROM Luogo, Viaggio WHERE Luogo.id = Viaggio.luogo_partenza AND Viaggio.id = '.$id);
	$res = $q->fetch_row();
	$q->free_result();
	$riga = [];
	array_push($arr, [floatval($res[0]), floatval($res[1])]);
	$q = $conn->query('SELECT longitudine, latitudine, Luogo.nome FROM Luogo, Tappa WHERE Luogo.id = Tappa.luogo_arrivo AND Tappa.viaggio = '.$id);
	$j = $q->num_rows;
	for ($i = 0; $i < $j; $i++) {
		$res = $q->fetch_row();
		$riga = [];
		array_push($arr, [floatval($res[0]), floatval($res[1])]);
	};
	$q->free_result();
	unset($_POST["id"]);
	echo json_encode($arr);
?>
