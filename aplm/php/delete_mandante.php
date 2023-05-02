<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$mand = $_POST['mandante'];
	$id = $_POST['id'];

	$q = $conn->query('SELECT persona, scopo FROM mandante WHERE persona = '.$mand.' AND scopo = '.$id);
	if ($q->num_rows == 0) {
		echo 'Mandante già eliminato.';
	} else {
		$res = $q->fetch_row();
		$q2 = $conn->prepare('DELETE FROM mandante WHERE persona = ? AND scopo = ?');
		$q2->bind_param("ii", $mand, $id);
		$q2->execute();
		$q2->store_result();
		$q2->free_result();
		echo 'Mandante eliminato.';
	};
	$q->free_result();
?>
