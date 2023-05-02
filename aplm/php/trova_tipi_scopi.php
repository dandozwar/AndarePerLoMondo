<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$tipi = array();
	$q = $conn->query('SELECT * FROM Tipo_Scopo ORDER BY tipo');
	$tottisc = $q->num_rows;
	for ($t = 0; $t < $tottisc; $t++) {
		$tisc = $q->fetch_row();
		$tipi[] = $tisc;
	};
	echo json_encode($tipi);
?>
