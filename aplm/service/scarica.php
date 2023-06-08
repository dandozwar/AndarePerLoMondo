<?php
	//$conn = new mysqli("localhost", "visitatore", "passvis", "aplm");
	$conn = new mysqli("localhost", "commentatore", "", "aplm");
	if (!$conn) {
		die('Connessione fallita: '.$conn->connect_error);
	};

	include '../php/functions_fonti.php';

	// contenuto pubblico del database
	$viaggi = array();
	$qv = $conn->query('SELECT id, titolo, fonte, pagine, piano, data_partenza, data_fine, intervallo_partenza, intervallo_fine, schedatore FROM Viaggio WHERE pubblico = 1');
	$totviag = $qv->num_rows;
	for ($v = 0; $v < $totviag; $v++){
		$dati_v = array();
		$luoghi = array();
		$viag = $qv->fetch_row();
		// raccolta dati sul viaggio
		$dp = "???";
		$df = "???";
		$qf = $conn->query('SELECT * FROM Fonte WHERE id='.$viag[2]);
		$font = $qf->fetch_row();
		$fo = get_Fonte($font);
		if ($viag[5] == null) {
			if ($viag[7] != null) {
				$qi = $conn->query('SELECT valore FROM Intervallo WHERE id='.$viag[7]);
				$inte = $qi->fetch_row();
				$dp = $inte[0];
			};
		} else {
			$dp = $viag[5];
		};
		if ($viag[6] == null) {
			if ($viag[8] != null) {
				$qi = $conn->query('SELECT valore FROM Intervallo WHERE id='.$viag[8]);
				$inte = $qi->fetch_row();
				$df = $inte[0];
			};
		} else {
			$df = $viag[6];
		};
		$dati_v = [$viag[0], $viag[1], $dp, $df, $fo, $viag[3], $viag[4], $viag[9]];
		// raccolta luoghi del viaggio
		$qt = $conn->query('(SELECT longitudine, latitudine FROM Luogo, Tappa WHERE Luogo.id = luogo_partenza AND viaggio = '.$viag[0].' AND posizione = 1) UNION (SELECT longitudine, latitudine FROM Luogo, Tappa WHERE Luogo.id = luogo_arrivo AND viaggio = '.$viag[0].' ORDER BY posizione)');
		$tottapp = $qt->num_rows;
		for ($t = 0; $t < $tottapp; $t++) {
			$tapp = $qt->fetch_row();
			$luoghi[] = [floatval($tapp[0]), floatval($tapp[1])];
		};
		$qt->free_result();
		$viaggi[] = [$dati_v, $luoghi];
	};

	// genera il testo
	$testo = '
		{
			"type": "FeatureCollection",
			"features": [';
	for ($v = 0; $v < count($viaggi); $v++){
		$testo = $testo.'{
				"type": "Feature",
				"properties": {
					"id": '.$viaggi[$v][0][0].',
					"titolo": "'.$viaggi[$v][0][1].'",
					"data_partenza": "'.$viaggi[$v][0][2].'",
					"data_fine": "'.$viaggi[$v][0][3].'",
					"fonte": "'.$viaggi[$v][0][4].'",
					"pagine": "'.$viaggi[$v][0][5].'",
					"piano":  "'.$viaggi[$v][0][6].'",
					"schedatore": "'.$viaggi[$v][0][7].'"
				},
				"geometry": {
					"coordinates": '.json_encode($viaggi[$v][1]).',
					"type": "LineString"
				}
			}';
		if ($v != ($totviag - 1)) {
			$testo = $testo.',';
		};
	};
	$testo = $testo.'
			]
		}';
	
	// crea il file
	$file = "aplm.json";
	$json = fopen($file, "w") or die("Impossibile aprire il file");
	fwrite($json, $testo);
	fclose($json);

	// scarica il file
	header('Content-Description: File Transfer');
	header('Content-Disposition: attachment; filename='.basename($file));
	header('Expires: 0');
	header('Cache-Control: must-revalidate');
	header('Pragma: public');
	header('Content-Length: '.filesize($file));
	header("Content-Type: text/plain");
	readfile($file);
?>
