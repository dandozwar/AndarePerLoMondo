<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$tr = $_POST["tipo_rela"];

	$q0 = $conn->query('SELECT * FROM Tipo_Relazione WHERE tipo = "'.$tr.'"');
	if ($q0->num_rows != 0) {
		echo 'Tipo relazione già inserito.';
	} else {
		$q = $conn->prepare('INSERT INTO Tipo_Relazione (tipo) VALUES (?)');
		$q->bind_param("s", $tr);
		$q->execute();
		$q->store_result();
		
		$qf = $conn->query('SELECT * FROM Tipo_Relazione WHERE id = (SELECT MAX(id) FROM Tipo_Relazione)');
		$res = $qf->fetch_row();
		echo json_encode($res);
	};
?>
