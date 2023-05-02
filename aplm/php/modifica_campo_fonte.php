<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$id = $_POST['id'];
	$campo = $_POST['campo'];
	$valore = $_POST['valore'];

	$query_string = 'UPDATE Fonte SET '.$campo.' = ? WHERE id = ?';
	$q = $conn->prepare($query_string);
	$q->bind_param("si", $valore, $id);
	$q->execute();
	echo 'Modifica effettuata.';
?>
