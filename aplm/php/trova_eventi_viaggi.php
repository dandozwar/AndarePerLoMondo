<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$id = $_POST["id"];
	$arr = array();
	$q = $conn->query('SELECT data_inizio, data_fine, titolo, Evento.didascalia AS descrizione, locazione, Immagine.didascalia AS didascalia, provenienza, uri FROM Evento, Immagine WHERE Immagine.id = immagine AND biografia = '.$id.' UNION SELECT data_inizio, data_fine, titolo, didascalia AS descrizione, NULL AS locazione, NULL AS didascalia, NULL AS provenienza, uri FROM Evento WHERE immagine IS NULL AND biografia = '.$id);
	$toteven = $q->num_rows;
	for ($e = 0; $e < $toteven; $e++) {
		$even = $q->fetch_row();
		array_push($arr, ["evento", $even[0], $even[1], $even[2], $even[3], $even[4], $even[5], $even[6], $even[7]]);
	};
	$q->free_result();
	$q = $conn->query('SELECT persona FROM Biografia WHERE id = '.$id);
	$persona = $q->fetch_row();
	$q->free_result();
	$q = $conn->query('SELECT id, data_partenza, luogo_partenza, data_fine, luogo_meta, titolo FROM Viaggio, partecipa_viaggio WHERE viaggio = id AND persona = '.$persona[0]);
	$totviag = $q->num_rows;
	for ($v = 0; $v < $totviag; $v++) {
		$viag = $q->fetch_row();
		$q2 = $conn->query('SELECT nome, latitudine, longitudine FROM Luogo WHERE id = '.$viag[2]);
		$lp = $q2->fetch_row();
		$q2->free_result();
		$q2 = $conn->query('SELECT nome FROM Luogo WHERE id = '.$viag[4]);
		$lm = $q2->fetch_row();
		$q2->free_result();
		array_push($arr, ["viaggio", $viag[0], $viag[1], $lp[0], $viag[3], $lm[0], $viag[5]]);
	};
	$q->free_result();
	unset($_POST["id"]);
	echo json_encode($arr);
?>
