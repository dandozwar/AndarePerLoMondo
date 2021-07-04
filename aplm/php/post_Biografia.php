<?php
	$conn = new mysqli("localhost", "root", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$id = $_POST["id"];
	$q = $conn->query('SELECT nome, cognome, presentazione, Biografia.id FROM Biografia, Persona WHERE persona = Persona.id AND Persona.id = '.$id);
	$biog = $q->fetch_row();
	$arr = [$biog[0], $biog[1], $biog[2], $biog[3]];
	$q->free_result();
	unset($_POST["id"]);
	echo json_encode($arr);
?>
