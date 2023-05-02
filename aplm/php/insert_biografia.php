<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$persona = $_POST["persona"];
	
	$q = $conn->prepare('INSERT INTO Biografia (persona) VALUES (?)');
	$q->bind_param("s", $persona);
	$q->execute();
	$q->store_result();

	$q2 = $conn->query('SELECT persona FROM Biografia WHERE persona = "'.$persona.'"');
	$arr_id = $q2->fetch_row();
	$res = [intval($arr_id[0])];
	echo json_encode($res);
?>
