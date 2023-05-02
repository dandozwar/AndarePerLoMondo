<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$intervalli = array();
	$q = $conn->query('SELECT id, stringa FROM Intervallo ORDER BY valore');
	$totinter = $q->num_rows;
	for ($i = 0; $i < $totinter; $i++) {
		$inter = $q->fetch_row();
		$intervalli[] = [$inter[0], $inter[1]];
	};
	echo json_encode($intervalli);
?>
