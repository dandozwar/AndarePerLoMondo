<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$fonti = array();
	$id = $_POST["id"];
	$q = $conn->query('SELECT DISTINCT Fonte.id, cit_biblio FROM Fonte, Tappa WHERE Fonte.id = fonte AND viaggio = '.$id);
	$totfont = $q->num_rows;
	for ($f = 0; $f < $totfont; $f++) {
		$font = $q->fetch_row();
		$fonti[] = [$font[0], $font[1]];
	};
	echo json_encode($fonti);
?>
