<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$occupazioni = array();
	$q = $conn->query('SELECT * FROM Occupazione ORDER BY attivita');
	$totoccu = $q->num_rows;
	for ($o = 0; $o < $totoccu; $o++) {
		$occu = $q->fetch_row();
		$occupazioni[] = $occu;
	};
	echo json_encode($occupazioni);
?>
