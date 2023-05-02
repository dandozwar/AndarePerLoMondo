<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$errori = array();
	$no = $_POST["nome"];
	$la = floatval($_POST["lat"]);
	$lo = floatval($_POST["lon"]);
	$ur = $_POST["uri"];

	$q = $conn->prepare('SELECT nome FROM Luogo WHERE (nome = ?)');
	$q->bind_param("s", $no);
	$q->execute();
	$q->store_result();
	if ($q->num_rows() != 0) {
		$errori[] = "nome già presente";
	};
	$q->free_result();

	// considerati 0.05 gradi come distanza minima fra due luoghi
	$q = $conn->prepare('SELECT latitudine, longitudine FROM Luogo WHERE (latitudine BETWEEN (? - 0.05) AND (? + 0.05)) AND (longitudine BETWEEN (? - 0.05) AND (? + 0.05))');
	$q->bind_param("dddd", $la, $la, $lo, $lo);
	$q->execute();
	$q->store_result();
	if ($q->num_rows() != 0) {
		$errori[] = "coppia di coordinate già presente";
	};
	$q->free_result();

	if (count($errori) == 0) {
		$q = $conn->prepare('INSERT INTO Luogo (nome, latitudine, longitudine, uri) VALUES (?, ?, ?, ?)');
		$q->bind_param("sdds", $no, $la, $lo, $ur);
		$q->execute();
		$q->free_result();
		echo "Operazione eseguita con successo.";
	} else {
		echo "Sono presenti i seguenti errori:";
		for ($i = 0; $i < count($errori); $i++) {
			if ($i != count($errori) - 1) {
				echo " ".$errori[$i].",";
			} else {
				echo " ".$errori[$i].".";
			};
		};
	};
?>
