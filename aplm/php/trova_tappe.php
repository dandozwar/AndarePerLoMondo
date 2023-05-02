<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$errori = array();
	$id = $_POST["viaggio"];
	$q = $conn->prepare('SELECT id FROM Viaggio WHERE id = ?');
	$q->bind_param("d", $id);
	$q->execute();
	$q->store_result();
	if ($q->num_rows() == 0) {
		$errori[] = "Viaggio non presente";
	};
	$q->free_result();
	
	if (count($errori) == 0) {
		$tappe = array();
		$q = $conn->query('SELECT * FROM Tappa WHERE viaggio = '.$id.' ORDER BY posizione');
		$tottapp = $q->num_rows;
		for ($t = 0; $t < $tottapp; $t++) {
			$tapp = $q->fetch_row();
			$q2 = $conn->query('SELECT nome, latitudine, longitudine, uri FROM Luogo WHERE id = '.$tapp[2]);
			$luogo = $q2->fetch_row();
			$luogo_partenza = $luogo[0];
			$lp_lat = $luogo[1];
			$lp_lon = $luogo[2];
			$lp_uri = $luogo[3];
			$q2->free_result();
			$q2 = $conn->query('SELECT nome, latitudine, longitudine, uri FROM Luogo WHERE id = '.$tapp[4]);
			$luogo = $q2->fetch_row();
			$luogo_arrivo = $luogo[0];
			$la_lat = $luogo[1];
			$la_lon = $luogo[2];
			$la_uri = $luogo[3];
			$q2->free_result();
			$tappe[] = [$tapp[0], $luogo_partenza, $tapp[3], $luogo_arrivo, $tapp[5], $tapp[6], $tapp[7], $lp_lat, $lp_lon, $la_lat, $la_lon, $tapp[8]];
		};
		echo json_encode($tappe);
	} else {
		echo json_encode($errori[0]);
	};
?>
