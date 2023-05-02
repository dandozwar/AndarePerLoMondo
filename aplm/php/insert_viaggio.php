<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$errori = array();
	$user = $_POST["nick"];
	$title = "Nuovo viaggio di ".$user;
	
	$q = $conn->prepare('SELECT titolo FROM Viaggio WHERE (titolo = ?)');
	$q->bind_param("s", $ti);
	$q->execute();
	$q->store_result();
	if ($q->num_rows() != 0)
		$errori[] = "Massimo un segnaposto per utente";
	$q->free_result();
	
	if (count($errori) == 0) {
		$q = $conn->prepare('INSERT INTO Viaggio (titolo, schedatore) VALUES (?, ?)');
		$q->bind_param("ss", $title, $user);
		$q->execute();
		$q->store_result();

		$q2 = $conn->query('SELECT MAX(id) FROM Viaggio WHERE schedatore = "'.$user.'"');
		$arr_id = $q2->fetch_row();
		$res = [intval($arr_id[0])];
		echo json_encode($res);
	} else {
		echo json_encode($errori);
	};
?>
