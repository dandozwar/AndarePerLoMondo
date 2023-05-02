<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$id = $_POST["id"];
	$q = $conn->query('SELECT nome, cognome, presentazione, Biografia.id FROM Biografia, Persona WHERE persona = Persona.id AND Persona.id = '.$id);
	$biog = $q->fetch_row();
	$arr = [$biog[0], $biog[1], $biog[2], $biog[3]];
	$q->free_result();
	unset($_POST["id"]);
	echo json_encode($arr);
?>
