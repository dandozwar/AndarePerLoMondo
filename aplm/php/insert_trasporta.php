<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$merc = $_POST['merce'];
	$id = $_POST['id'];

	$q0 = $conn->query('SELECT tappa, merce FROM trasporta WHERE tappa ='.$id.' AND merce = '.$merc);
	if ($q0->num_rows != 0) {
		echo 'Merce già trasportata nella tappa.';
	} else {
		$q = $conn->prepare('INSERT INTO trasporta (tappa, merce) VALUES (?, ?)');
		$q->bind_param("ii", $id, $merc);
		$q->execute();
		$q->store_result();
		echo 'Merce aggiunta a quelle trasportate.';
	};
?>
