<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$p1 = $_POST["persona1"];
	
	$q = $conn->prepare('INSERT INTO relazione (persona1) VALUES (?)');
	$q->bind_param("i", $p1);
	$q->execute();
	$q->store_result();
	$q2 = $conn->query('SELECT id FROM relazione WHERE id = (SELECT MAX(id) FROM relazione WHERE persona1 = '.$p1.')');
	$arr_id = $q2->fetch_row();
	$res = [intval($arr_id[0])];
	echo json_encode($res);
?>
