<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_vis.php';

	$biografie = array();
	$q = $conn->query('SELECT Biografia.id, persona FROM Biografia, Persona WHERE persona = Persona.id AND pubblico = 1 ORDER BY COALESCE(Persona.data_nascita, Persona.data_morte)');
	$totbiog = $q->num_rows;
	for ($b = 0; $b < $totbiog; $b++){
		$biog = $q->fetch_row();
		array_push($biografie, [$biog[0], $biog[1]]);
	};
	$q->free_result();
	$res = array();
	for ($b = 0; $b < count($biografie); $b++) {
		$q = $conn->query('SELECT viaggio1 AS viaggio FROM Biografia WHERE persona = '.$biografie[$b][1].' AND pubblico = 1 UNION SELECT viaggio2 AS viaggio FROM Biografia WHERE persona = '.$biografie[$b][1].'  AND pubblico = 1');
		$totviag = $q->num_rows;
		$luoghi = array();
		for ($v = 0; $v < $totviag; $v++) {
			$viag = $q->fetch_row();
			if ($viag[0] != NULL) {
				$q2 = $conn->query('SELECT L1.longitudine, L1.latitudine, L1.nome, L2.longitudine, L2.latitudine, L2.nome FROM Luogo AS L1, Luogo AS L2, Tappa WHERE L1.id = luogo_partenza AND L2.id = luogo_arrivo AND viaggio = '.$viag[0].' ORDER BY posizione');
				$tottapp = $q2->num_rows;
				for ($t = 0; $t < $tottapp; $t++) {
					$tapp = $q2->fetch_row();
					$luoghi[] = $tapp;
				};
				$q2->free_result();
			};
		};
		$q->free_result();
		$res[] = [$biografie[$b], $luoghi];
	};
	$_POST = array();
	echo json_encode($res);
?>
