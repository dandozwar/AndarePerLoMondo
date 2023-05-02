<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$id = 0;
	$cit = "";
	$no = $_POST["nome"];
	$i = 0;

	$q = $conn->prepare('SELECT id, nome FROM Luogo WHERE (nome = ?)');
	$q->bind_param("s", $no);
	$q->execute();
	$q->store_result();
	if ($q->num_rows() == 1) {
		$q->bind_result($id, $nom);
		$q->fetch();
	} else {
		echo "Errore!";
	};
	$q->free_result();

	echo json_encode([$id, $nom]);
?>
