<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$ti = $_POST["tipo"];

	$q0 = $conn->query('SELECT * FROM Tipo_Scopo WHERE tipo = "'.$ti.'"');
	if ($q0->num_rows != 0) {
		echo 'Scopo già inserito.';
	} else {
		$q = $conn->prepare('INSERT INTO Tipo_Scopo (tipo) VALUES (?)');
		$q->bind_param("s", $ti);
		$q->execute();
		$q->store_result();
		
		$qf = $conn->query('SELECT * FROM Tipo_Scopo WHERE id = (SELECT MAX(id) FROM Tipo_Scopo)');
		$res = $qf->fetch_row();
		echo json_encode($res);
	};
?>
