<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$id = $_POST["id"];
	$luoghi = array();
	$q = $conn->query('SELECT nome, latitudine, longitudine FROM Luogo WHERE id='.$id);
	$luogo = $q->fetch_row();
	echo json_encode($luogo);
?>
