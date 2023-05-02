<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';


	//Include le funzioni
	include 'functions_fonti.php';

	$user = $_POST['utente'];
	
	$fonti = array();
	$q = $conn->query('SELECT * FROM Fonte WHERE schedatore != "'.$user.'"');
	$totfont = $q->num_rows;
	for ($f = 0; $f < $totfont; $f++) {
		$font = $q->fetch_row();
		$fonti[] = [$font[0], get_Fonte($font)];
	};
	echo json_encode($fonti);
?>
