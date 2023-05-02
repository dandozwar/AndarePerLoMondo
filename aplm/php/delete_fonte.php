<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$user = $_POST["nick"];
	$id = $_POST["id"];
	
	$q = $conn->query('SELECT schedatore FROM Fonte WHERE id = '.$id);
	if ($q->num_rows == 0) {
		echo 'Fonte già eliminata.';
	} else {
		$res = $q->fetch_row();
		if ($res[0] == $user) {
			$q1 = $conn->query('SELECT id FROM Viaggio WHERE Fonte = '.$id);
			if ($q1->num_rows == 0) {
				$q3 = $conn->prepare('DELETE FROM Fonte WHERE id = ?');
				$q3->bind_param("i", $id);
				$q3->execute();
				$q3->store_result();
				$q3->free_result();
				echo 'Fonte eliminata.';
			} else {
				echo 'Ci sono ancora viaggi collegati alla fonte.';
			};
		} else {
			echo 'Eliminazione non autorizzata.';
		};
	};
	$q->free_result();
?>
