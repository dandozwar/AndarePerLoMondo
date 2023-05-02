<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$viaggio = $_POST["viaggio"];
	
	$qp = $conn->query('SELECT MAX(posizione) + 1 FROM Tappa WHERE viaggio = '.$viaggio);
	$arr_pos = $qp->fetch_row();
	if (is_null($arr_pos[0])) {
		$arr_pos[0] = 1;
	};

	$q = $conn->prepare('INSERT INTO Tappa (posizione, viaggio) VALUES (?, ?)');
	$q->bind_param("ii", $arr_pos[0], $viaggio);
	$q->execute();
	$q->store_result();

	$q2 = $conn->query('SELECT MAX(id) FROM Tappa WHERE viaggio = '.$viaggio);
	$arr_id = $q2->fetch_row();
	$res = [intval($arr_id[0])];
	echo json_encode($res);
?>
