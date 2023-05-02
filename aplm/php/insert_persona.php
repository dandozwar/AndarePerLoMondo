<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$user = $_POST["nick"];
	
	$q = $conn->prepare('INSERT INTO Persona (schedatore) VALUES (?)');
	$q->bind_param("s", $user);
	$q->execute();
	$q->store_result();

	$q2 = $conn->query('SELECT MAX(id) FROM Persona WHERE schedatore = "'.$user.'"');
	$arr_id = $q2->fetch_row();
	$res = [intval($arr_id[0])];
	echo json_encode($res);
?>
