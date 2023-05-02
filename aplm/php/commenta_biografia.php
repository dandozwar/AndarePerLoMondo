<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$nick = $_POST["nick"];
	$persona = $_POST["persona"];
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
			$q->free_result();
			$q2 = $conn->prepare('SELECT id FROM Biografia WHERE persona = ?');
			$q2->bind_param("i", $persona);
			$q2->execute();
			$q2->store_result();
			$q2->bind_result($bio);
			$q2->fetch();
			$q2->store_result();
			$q2 = $conn->prepare('INSERT INTO Commento_Biografia (autore, biografia, commento) VALUES (?, '.$bio.', ?)');
			$q2->bind_param("ss", $nick, $testo);
			$q2->execute();
			$q2->free_result();
			echo 'Commento inserito.';
		};
	};
?>
