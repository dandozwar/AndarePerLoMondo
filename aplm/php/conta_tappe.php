<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$errori = array();
	$id = $_POST["id"];
	$q = $conn->prepare('SELECT id FROM Viaggio WHERE id = ?');
	$q->bind_param("d", $id);
	$q->execute();
	$q->store_result();
	if ($q->num_rows() == 0) {
		$errori[] = "Viaggio non presente";
	};
	$q->free_result();
	
	if (count($errori) == 0) {
		$q = $conn->query('SELECT id FROM Tappa WHERE viaggio = '.$id.' ORDER BY posizione');
		$tottapp = $q->num_rows;
		echo json_encode($tottapp);
	} else {
		echo json_encode($errori[0]);
	};
?>
