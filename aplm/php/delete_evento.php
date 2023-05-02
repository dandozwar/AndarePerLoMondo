<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$id = $_POST["id"];
	
	$q = $conn->query('SELECT id FROM Evento WHERE id = '.$id);
	if ($q->num_rows == 0) {
		echo 'Evento già eliminato.';
	} else {
		$res = $q->fetch_row();
		$q2 = $conn->prepare('DELETE FROM Evento WHERE id = ?');
		$q2->bind_param("i", $res[0]);
		$q2->execute();
		$q2->store_result();
		$q2->free_result();
		echo 'Evento eliminato.';
	};
	$q->free_result();
?>
