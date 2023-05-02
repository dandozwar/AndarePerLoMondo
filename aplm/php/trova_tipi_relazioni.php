<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$tipi = array();
	$q = $conn->query('SELECT * FROM Tipo_Relazione ORDER BY tipo');
	$tottire = $q->num_rows;
	for ($t = 0; $t < $tottire; $t++) {
		$tire = $q->fetch_row();
		$tipi[] = $tire;
	};
	echo json_encode($tipi);
?>
