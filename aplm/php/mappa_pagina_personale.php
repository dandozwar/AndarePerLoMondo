<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$nick = $_POST["nick"];
	$viaggi = array();
	$q = $conn->query('SELECT id FROM Viaggio WHERE schedatore = "'.$nick.'" ORDER BY COALESCE(data_partenza, data_fine)'); // non ordina gli intervalli!
	$totviag = $q->num_rows;
	for ($v = 0; $v < $totviag; $v++) {
		$viag = $q->fetch_row();
		$viaggi[] = $viag[0];
	};
	$q->free_result();
	$res = array();
	for ($v = 0; $v < count($viaggi); $v++) {
		$q = $conn->query('SELECT id, titolo, data_partenza, intervallo_partenza, data_fine, intervallo_fine, fonte, pagine FROM Viaggio WHERE id = '.$viaggi[$v]);
		$info = $q->fetch_row();
		$q->free_result();
		if ($info[3] != null) {
			$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$info[3]);
			$arr_i = $qi->fetch_row();
			$info[3] = $arr_i[0];
		};
		if ($info[5] != null) {
			$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$info[5]);
			$arr_i = $qi->fetch_row();
			$info[5] = $arr_i[0];
		};
		$luoghi = array();
		$q2 = $conn->query('SELECT L1.longitudine, L1.latitudine, L1.nome, L2.longitudine, L2.latitudine, L2.nome FROM Luogo AS L1, Luogo AS L2, Tappa WHERE L1.id = luogo_partenza AND L2.id = luogo_arrivo AND viaggio = '.$viaggi[$v].' ORDER BY posizione');
		$tottapp = $q2->num_rows;
		for ($t = 0; $t < $tottapp; $t++) {
			$tapp = $q2->fetch_row();
			$luoghi[] = $tapp;
		};
		$q2->free_result();
		$res[] = [$info, $luoghi];
	};
	$_POST = array();
	echo json_encode($res);
?>
