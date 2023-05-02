<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$id = $_POST["id"];
	
	$q = $conn->query('SELECT id FROM relazione WHERE id = '.$id);
	if ($q->num_rows == 0) {
		echo 'Relazione già eliminata.';
	} else {
		$res = $q->fetch_row();
		$q2 = $conn->prepare('DELETE FROM relazione WHERE id = ?');
		$q2->bind_param("i", $id);
		$q2->execute();
		$q2->store_result();
		$q2->free_result();
		echo 'Relazione eliminata.';
	};
	$q->free_result();
?>
