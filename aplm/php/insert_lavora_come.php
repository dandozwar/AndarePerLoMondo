<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$pers = $_POST["persona"];
	
	$q = $conn->prepare('INSERT INTO lavora_come (persona) VALUES (?)');
	$q->bind_param("i", $pers);
	$q->execute();
	$q->store_result();
	$q2 = $conn->query('SELECT id FROM lavora_come WHERE id = (SELECT MAX(id) FROM lavora_come WHERE persona = '.$pers.')');
	$arr_id = $q2->fetch_row();
	$res = [intval($arr_id[0])];
	echo json_encode($res);
?>
