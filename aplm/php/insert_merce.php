<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$ti = $_POST["tipo"];
	$qu = $_POST["quantita"];
	$va = $_POST["valore"];

	$q0 = $conn->query('SELECT * FROM Merce WHERE tipo = "'.$ti.'" AND quantita = "'.$qu.'" AND valore = "'.$va.'"');
	if ($q0->num_rows != 0) {
		echo 'Merce già inserita.';
	} else {
		$q = $conn->prepare('INSERT INTO Merce (tipo, quantita, valore) VALUES (?, ?, ?)');
		$q->bind_param("sss", $ti, $qu, $va);
		$q->execute();
		$q->store_result();
		
		$qf = $conn->query('SELECT * FROM Merce WHERE id = (SELECT MAX(id) FROM Merce)');
		$res = $qf->fetch_row();
		$stringa = $res[1].', quantità '.$res[2].', valore '.$res[3];
		echo json_encode([$res[0], $stringa]);
	};
?>
