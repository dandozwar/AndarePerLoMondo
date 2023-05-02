<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$idpersona = $_POST["id"];
	$viaggi = array();
	$q = $conn->query('SELECT viaggio FROM partecipa_viaggio, Viaggio WHERE viaggio = Viaggio.id AND persona ='.$idpersona.' ORDER BY COALESCE(data_partenza, data_fine)');
	$totviag = $q->num_rows;
	for ($v = 0; $v < $totviag; $v++) {
		$viag = $q->fetch_row();
		$viaggi[] = $viag[0];
	};
	$q->free_result();
	$res = array();
	for ($v = 0; $v < count($viaggi); $v++) {
		$q = $conn->query('SELECT titolo, data_partenza, data_fine, id, fonte, pagine, intervallo_partenza, intervallo_fine FROM Viaggio WHERE id = '.$viaggi[$v]);
		// controllo intervalli
		$info = $q->fetch_row();
		if ($info[6]) {
			$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$info[6]);
			$inte = $qi->fetch_row();
			$info[6] = $inte[0];
		} else {
			$info[6] = "?";
		};
		if ($info[7]) {
			$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$info[7]);
			$inte = $qi->fetch_row();
			$info[7] = $inte[0];
		} else {
			$info[7] = "?";
		};
		$q->free_result();
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
