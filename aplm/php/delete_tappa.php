<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$id = $_POST['id'];
	$pos = $_POST['pos'];
	$vi = $_POST['viaggio'];

	$q0 = $conn->prepare('SELECT id FROM Tappa WHERE viaggio = ?');
	$q0->bind_param("i", $vi);
	$q0->execute();
	$q0->store_result();
	$total = $q0->num_rows();
	$q0->free_result();

	$q1 = $conn->prepare('DELETE FROM Tappa WHERE id = ?');
	$q1->bind_param("i", $id);
	$q1->execute();
	$q1->store_result();
	$q1->free_result();

	for ($t = $pos + 1; $t <= $total; $t++) {
		$q2 = $conn->prepare('UPDATE Tappa SET posizione = (? - 1) WHERE posizione = ? AND viaggio = ? ');
		$q2->bind_param("iii", $t, $t, $vi);
		$q2->execute();
		$q2->free_result();
		$q2->free_result();
	};

	echo 'Tappa eliminata.';
?>
