<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$dest = $_POST['destinatario'];
	$id = $_POST['id'];

	$q = $conn->query('SELECT persona, scopo FROM destinatario WHERE persona = '.$dest.' AND scopo = '.$id);
	if ($q->num_rows == 0) {
		echo 'Destinatario già eliminato.';
	} else {
		$res = $q->fetch_row();
		$q2 = $conn->prepare('DELETE FROM destinatario WHERE persona = ? AND scopo = ?');
		$q2->bind_param("ii", $dest, $id);
		$q2->execute();
		$q2->store_result();
		$q2->free_result();
		echo 'Destinatario eliminato.';
	};
	$q->free_result();
?>
