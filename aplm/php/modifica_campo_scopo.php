<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$scopo = $_POST['id'];
	$campo = $_POST['campo'];
	$valore = $_POST['valore'];

	$query_string = 'UPDATE Scopo SET '.$campo.' = ? WHERE id = ?';
	$q = $conn->prepare($query_string);
	$q->bind_param("si", $valore, $scopo);
	$q->execute();
	echo 'Modifica effettuata.';
?>
