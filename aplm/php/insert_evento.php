<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$biografia = $_POST["biografia"];
	$titolo = 'Senza titolo';
	
	$q = $conn->prepare('INSERT INTO Evento (biografia, titolo) VALUES (?, ?)');
	$q->bind_param("ss", $biografia, $titolo);
	$q->execute();
	$q->store_result();

	$q2 = $conn->query('SELECT MAX(id) FROM Evento WHERE biografia = "'.$biografia.'"');
	$arr_id = $q2->fetch_row();
	$res = [intval($arr_id[0])];
	echo json_encode($res);
?>
