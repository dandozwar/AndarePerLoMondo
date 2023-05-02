<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$id = $_POST["id"];
	$arr = array();
	$q = $conn->query('SELECT L1.longitudine, L1.latitudine, L1.nome, L2.longitudine, L2.latitudine, L2.nome FROM Luogo AS L1, Luogo AS L2, Tappa WHERE L1.id = luogo_partenza AND L2.id = luogo_arrivo AND viaggio = '.$id.' ORDER BY posizione');
	$j = $q->num_rows;
	for ($i = 0; $i < $j; $i++) {
		$res = $q->fetch_row();
		$arr[] = $res;
	};
	$q->free_result();
	unset($_POST["id"]);
	echo json_encode($arr);
?>
