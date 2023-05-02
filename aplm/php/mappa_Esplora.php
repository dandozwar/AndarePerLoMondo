<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$viaggi = array();
	foreach ($_POST as $chiave => $valore) {
		$viaggi[] = $valore;
	};
	$viaggi = array_unique($viaggi);
	$res = array();
	for ($v = 0; $v < count($viaggi); $v++) {
		$q = $conn->prepare('SELECT titolo, data_partenza, data_fine, id FROM Viaggio WHERE id = ?');
		$q->bind_param('i', $viaggi[$v]);
		$q->execute();
		$q->store_result();
		$q->bind_result($titolo, $dp, $df, $id);
		$q->fetch();
		$q->free_result();
		$info = [$titolo, $dp, $df, $id];
		$luoghi = array();
		$q = $conn->query('SELECT L1.longitudine, L1.latitudine, L1.nome, L2.longitudine, L2.latitudine, L2.nome FROM Luogo AS L1, Luogo AS L2, Tappa WHERE L1.id = luogo_partenza AND L2.id = luogo_arrivo AND viaggio = '.$viaggi[$v].' ORDER BY posizione');
		$tottapp = $q->num_rows;
		for ($t = 0; $t < $tottapp; $t++) {
			$tapp = $q->fetch_row();
			$luoghi[] = $tapp;
		};
		$q->free_result();
		$res[] = [$info, $luoghi];
	};
	$_POST = array();
	echo json_encode($res);
?>
