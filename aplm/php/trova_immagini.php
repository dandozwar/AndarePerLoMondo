<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$immagini = array();
	$q = $conn->query('SELECT id, locazione, didascalia, provenienza FROM Immagine');
	$totimma = $q->num_rows;
	for ($i = 0; $i < $totimma; $i++) {
		$immag = $q->fetch_row();
		$immagini[] = $immag;
	};
	echo json_encode($immagini);
?>
