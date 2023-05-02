<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$errori = array();
	$user = $_POST["nick"];
	$id = $_POST["id"];
	
	$q = $conn->query('SELECT schedatore FROM Viaggio WHERE id = '.$id);
	if ($q->num_rows == 0) {
		echo 'Viaggio già eliminato.';
	} else {
		$res = $q->fetch_row();
		if ($res[0] == $user) {
			$q2 = $conn->prepare('DELETE FROM Viaggio WHERE id = ?');
			$q2->bind_param("i", $id);
			$q2->execute();
			$q2->store_result();
			$q2->free_result();
			echo 'Viaggio eliminato.';
		} else {
			echo 'Eliminazione non autorizzata.';
		};
	};
	$q->free_result();
?>
