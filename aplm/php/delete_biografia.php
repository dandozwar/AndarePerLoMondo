<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$persona = $_POST["persona"];
	
	$q = $conn->query('SELECT id FROM Biografia WHERE persona = '.$persona);
	if ($q->num_rows == 0) {
		echo 'Biografia già eliminata.';
	} else {
		$res = $q->fetch_row();
		$q2 = $conn->prepare('DELETE FROM Biografia WHERE id = ?');
		$q2->bind_param("i", $res[0]);
		$q2->execute();
		$q2->store_result();
		$q2->free_result();
		echo 'Biografia eliminata.';
	};
	$q->free_result();
?>
