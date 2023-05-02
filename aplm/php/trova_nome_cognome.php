<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$id = $_POST["id"];
	$q = $conn->query('SELECT nome, cognome FROM Persona WHERE id = '.$id);
	$res = $q->fetch_row();
	$q->free_result();
	unset($_POST["id"]);
	echo json_encode($res);
?>
