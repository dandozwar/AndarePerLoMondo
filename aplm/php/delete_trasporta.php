<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$merc = $_POST['merce'];
	$id = $_POST['id'];

	$q = $conn->query('SELECT * FROM trasporta WHERE merce = '.$merc.' AND tappa = '.$id);
	if ($q->num_rows == 0) {
		echo 'Merce già rimossa da quelle trasportate.';
	} else {
		$res = $q->fetch_row();
		$q2 = $conn->prepare('DELETE FROM trasporta WHERE merce = ? AND tappa = ?');
		$q2->bind_param("ii", $merc, $id);
		$q2->execute();
		$q2->store_result();
		$q2->free_result();
		echo 'Merce rimossa da quelle trasportate.';
	};
	$q->free_result();
?>
