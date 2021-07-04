<?php
	$conn = new mysqli("localhost", "root", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$id = $_POST["id"];
	$q = $conn->query('SELECT nome, cognome FROM Persona WHERE id = '.$id);
	$res = $q->fetch_row();
	$q->free_result();
	unset($_POST["id"]);
	echo json_encode($res);
?>
