<?php
	// Stabilisce una connessione con il database
	$conn = new mysqli("localhost", "commentatore", "", "aplm");
	if (!$conn) {
		die('Connessione fallita: '.$conn->connect_error);
	};
?>
