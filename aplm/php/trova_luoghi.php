<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$luoghi = array();
	$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
	$totluog = $q->num_rows;
	for ($l = 0; $l < $totluog; $l++) {
		$luog = $q->fetch_row();
		$luoghi[] = [$luog[0], $luog[1]];
	};
	echo json_encode($luoghi);
?>
