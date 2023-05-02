<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';


	$id = $_POST['id'];

	$q = $conn->query('SELECT * FROM Fonte WHERE id = '.$id);
	$res = $q->fetch_row();
	
	echo json_encode($res);
