<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$at = $_POST["attivita"];

	$q0 = $conn->query('SELECT * FROM Occupazione WHERE attivita = "'.$at.'"');
	if ($q0->num_rows != 0) {
		echo 'Attività già inserita.';
	} else {
		$q = $conn->prepare('INSERT INTO Occupazione (attivita) VALUES (?)');
		$q->bind_param("s", $at);
		$q->execute();
		$q->store_result();
		
		$qf = $conn->query('SELECT * FROM Occupazione WHERE id = (SELECT MAX(id) FROM Occupazione)');
		$res = $qf->fetch_row();
		echo json_encode($res);
	};
?>
