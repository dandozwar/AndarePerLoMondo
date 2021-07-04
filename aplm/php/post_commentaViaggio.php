<?php
	$conn = new mysqli("localhost", "commentatore", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$nick = $_POST["nick"];
	$viaggio = $_POST["viaggio"];
	$testo = $_POST["testo"];
	if ($testo == "") {
		echo "Errore! Commento vuoto.";
	} else {
		$q = $conn->prepare('SELECT nick FROM Utente WHERE nick = ?');
		$q->bind_param("s", $nick);
		$q->execute();
		$q->store_result();
		if ($q->num_rows() == 0) {
			$q->free_result();
			echo 'Errore, nickname manomesso.';
		} else {
			$q2 = $conn->prepare('INSERT INTO Commento_Viaggio (autore, viaggio, commento) VALUES (?, '.$viaggio.', ?)');
			$q2->bind_param("ss", $nick, $testo);
			$q2->execute();
			$q2->free_result();
			echo 'Commento inserito.';
		};
	};
?>
