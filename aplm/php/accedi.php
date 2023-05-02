<?php
	session_start();
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$errori = [0, 0];
	$nick = $_POST["nick"];
	$pass = $_POST["pass"];
	if ($nick != "" && strlen($nick) > 2 && strlen($nick) <= 16) {
		$q = $conn->prepare('SELECT nick FROM Utente WHERE nick = ?');
		$q->bind_param("s", $nick);
		$q->execute();
		$q->store_result();
		if ($q->num_rows() == 1) {
			if ($pass != "" && strlen($pass) > 2 && strlen($pass) < 17) {
				$q2 = $conn->query('SELECT password FROM Utente WHERE nick = "'.$nick.'"');
				$truePass = $q2->fetch_row();
				if ($truePass[0] != $pass) {
					echo "Password sbagliata. ";
					$errori[1] = 1;
				};
				$q2->free_result();
			} else {
				echo "Lunghezza password errata. ";
				$errori[1] = 1;
			};
		} else {
			$errori[0] = 1;
		};
		$q->free_result();
	} else {
		$errori[0] = 1;
	};
	if (in_array(1, $errori) == false) {
		echo "Bentornato ".$nick;
		$_SESSION["nick"] = $nick;
		$_SESSION["pass"] = $pass;
		$_SESSION["time"] = time();
	} else {
		echo "Errore! Controllare di aver inserito correttamente i campi.";
	};
	unset($_POST["nick"]);
	unset($_POST["pass"]);
?>
