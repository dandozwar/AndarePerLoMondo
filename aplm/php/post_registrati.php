<?php
	session_start();
	$conn = new mysqli("localhost", "root", "", "aplm");
	if (!$conn) {
		die("Errore di connessione: ".$mysqli->connect_error);
	};
	$errori = [0, 0, 0, 0, 0, 0];
	$nick = $_POST["nick"];
	$pass = $_POST["pass"];
	$nome = $_POST["nome"];
	$cognome = $_POST["cognome"];
	$ente = $_POST["ente"];
	$ruolo = $_POST["ruolo"];
	if ($nick != "" && strlen($nick) > 2 && strlen($nick) <= 16) {
		$q = $conn->prepare('SELECT nick FROM Utente WHERE nick = ?');
		$q->bind_param("s", $nick);
		$q->execute();
		$q->store_result();
		if ($q->num_rows() != 0) {
			$errori[0] = 1;
		};
		$q->free_result();
	} else {
		$errori[0] = 1;
	};
	if ($pass == "" || strlen($pass) < 3 || strlen($pass) > 16) {
		$errori[1] = 1;
	};
	if ($nome == "") {
		$errori[2] = 1;
	};
	if ($cognome == "") {
		$errori[3] = 1;
	};
	if ($ente == "") {
		$errori[4] = 1;
	};
	if ($ruolo == "") {
		$errori[5] = 1;
	};
	if (in_array(1, $errori) == false) {
		$q = $conn->prepare('INSERT INTO Utente (nick, password, nome, cognome, ente, ruolo) VALUES (?, ?, ?, ?, ?, ?)');
		$q->bind_param("ssssss", $nick, $pass, $nome, $cognome, $ente, $ruolo);
		$q->execute();
		$q->free_result();
		echo "Operazione eseguita con successo.";
		$_SESSION["nick"] = $nick;
		$_SESSION["pass"] = $pass;
		$_SESSION["time"] = time();
	} else {
		echo "Errore! Controllare di aver inserito correttamente i campi.";
	};
	unset($_POST["nick"]);
	unset($_POST["pass"]);
	unset($_POST["nome"]);
	unset($_POST["cognome"]);
	unset($_POST["ente"]);
	unset($_POST["ruolo"]);
?>
