<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';

	$errori = array();
	$ti = $_POST['titolo'];
	$di = $_POST['didascalia'];
	$pr = $_POST['provenienza'];
	$im = $_FILES['im_file'];

	$qt = $conn->query('SELECT locazione FROM Immagine');
	$totimma = $qt->num_rows;
	for ($i = 0; $i < $totimma; $i++) {
		$imma = $qt->fetch_row();
		preg_match('/\\.\\/img\\/eventi\\/(.+)\\.(png|gif|jpg|jpeg)/', $imma[0], $im_titolo);
		if ($im_titolo[1] == $ti) {
			$errori[] = 'Titolo già presente.';
			break;
		};
	};
	if (empty($errori)) {
		if ($im['name'] != '') {
			if (!(in_array($im['type'], array('image/jpeg', 'image/png', 'image/gif')))) {
				$errori[] = 'Estensione non supportata.';
			} else {
				$imdata = getimagesize($im['tmp_name']);
				if (($imdata[0] > 1366) || ($imdata[1] > 768)) {
					$errori[] = 'Risoluzione troppo alta.';
				} else {
					if ($im['size'] > 2000000) {
						$errori[] = 'Immagine troppo pesante.';
					};
				};
			};
		} else {
			$errori[] = 'Nessuna immagine caricata.';
		};
	};
	if (empty($errori)) {
		$nomefile = './img/eventi/'.$ti.'.'.pathinfo($im['name'], PATHINFO_EXTENSION);
		move_uploaded_file($im['tmp_name'], '../'.$nomefile);
		$q = $conn->prepare('INSERT INTO Immagine (locazione, didascalia, provenienza) VALUES (?, ?, ?)');
		$q->bind_param('sss', $nomefile, $di, $pr);
		$q->execute();
		$q->free_result();
		
		$q2 = $conn->query('SELECT id FROM Immagine WHERE locazione = "'.$nomefile.'"');
		$nuov_id = $q2->fetch_row();
		echo json_encode[$nuovo_id[0], $di];
	};
?>
