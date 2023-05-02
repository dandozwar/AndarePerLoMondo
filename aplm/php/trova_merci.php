<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$merci = array();
	$q = $conn->query('SELECT * FROM Merce');
	$totmerc = $q->num_rows;
	for ($m = 0; $m < $totmerc; $m++) {
		$merc = $q->fetch_row();
		$merci[] = $merc;
	};
	echo json_encode($merci);
?>
