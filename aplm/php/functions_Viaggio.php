<?php
	function get_Scopo($tipo, $id, $conn) {
		$textScop = "";
		if ($tipo == "Viaggio") {
			$q = $conn->query('SELECT Tipo_Scopo.tipo, Scopo.id FROM Tipo_Scopo, Scopo, motivo_viaggio WHERE Scopo.id = motivo_viaggio.scopo AND motivo_viaggio.viaggio = '.$id.' AND Scopo.tipo = Tipo_Scopo.id');
			$j = $q->num_rows;
			if ($j > 0) {
				$textScop = $textScop.'aveva lo scopo di ';
				if ($j == 1) {
					$res = $q->fetch_row();
					$textScop = $textScop.$res[0];
					// Destinatari viaggio
					$textScop = $textScop.get_Destinatari ("Viaggio", $res[1], $conn);
					// Mandanti viaggio
					$textScop = $textScop.get_Mandanti ("Viaggio", $res[1], $conn);
				} else {
					for ($i = 0; $i < $j; $i++) {
						$res = $q->fetch_row();
						if ($i == $j-1) {
							$textScop = $textScop.' e '.$res[0];
							// Destinatari viaggio
							$textScop = $textScop.get_Destinatari ("Viaggio", $res[1], $conn);
							// Mandanti viaggio
							$textScop = $textScop.get_Mandanti ("Viaggio", $res[1], $conn);
						} else {
							$textScop = $textScop.$res[0];
							// Destinatari viaggio
							$textScop = $textScop.get_Destinatari ("Viaggio", $res[1], $conn);
							// Mandanti viaggio
							$textScop = $textScop.get_Mandanti ("Viaggio", $res[1], $conn);
						};
					};
				};
			};
			$q->free_result();
		} elseif ($tipo == "Tappa") {
			$q = $conn->query('SELECT Tipo_Scopo.tipo, Scopo.id FROM Tipo_Scopo, Scopo, motivo_tappa WHERE Scopo.id = motivo_tappa.scopo AND motivo_tappa.tappa = '.$id.' AND Scopo.tipo = Tipo_Scopo.id');
			$j = $q->num_rows;
			if ($j > 0) {
				$textScop = $textScop.', con lo scopo di ';
				if ($j == 1) {
					$res = $q->fetch_row();
					$textScop = $textScop.$res[0];
					// Destinatari tappa
					$textScop = $textScop.get_Destinatari ("Tappa", $res[1], $conn);
					// Mandanti tappa
					$textScop = $textScop.get_Mandanti ("Tappa", $res[1], $conn);
				} else {
					for ($i = 0; $i < $j; $i++) {
						$res = $q->fetch_row();
						if ($i == $j-1) {
							$textScop = $textScop.' e '.$res[0];
							// Destinatari tappa
							$textScop = $textScop.get_Destinatari ("Tappa", $res[1], $conn);
							// Mandanti tappa
							$textScop = $textScop.get_Mandanti ("Tappa", $res[1], $conn);
						} else {
							$textScop = $textScop.$res[0];
							// Destinatari tappa
							$textScop = $textScop.get_Destinatari ("Tappa", $res[1], $conn);
							// Mandanti tappa
							$textScop = $textScop.get_Mandanti ("Tappa", $res[1], $conn);
						};
					};
				};
			};
			$q->free_result();
		};
		return $textScop;
	};

	// Funzione per i destinatari
	function get_Destinatari ($tipo, $idscopo, $conn) {
		$textDest = "";
		$q2 = $conn->query('SELECT nome, cognome, id, uri FROM destinatario, Persona WHERE id = persona AND scopo = '.$idscopo);
		$k = $q2->num_rows;
		if ($k > 0) {
			$textDest = $textDest.' ';
			if ($k == 1) {
				$dest = $q2->fetch_row();
				$textDest = $textDest.'<span id="p'.$dest[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$dest[0].' '.$dest[1].'</span>';
				$textDest = $textDest.'<div id="pop_p'.$dest[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
						<h3>'.$dest[0].' '.$dest[1].' '.get_Vita($dest[2], $conn).'</h3>
								<p>'.get_Bio($dest[2], $conn).'</p>';
				$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$dest[2]);
				if ($qBio->num_rows != 0) {
					$textDest = $textDest.'<p><a href="./presentazione.php?persona='.$dest[2].'" target="_blank">Vai alla presentazione</a>.<p>';
				};
				$qBio->free_result();
				if ($dest[3] != NULL) { 
					$textDest = $textDest.'<p><a href="'.$dest[3].'" target="_blank">Vai alla biografia esterna</a>.<p>';
				};
				$textDest = $textDest.'</div>';
			} else {
				for ($count = 0; $count < $k; $count++) {
					$dest = $q2->fetch_row();
					if ($count == $k-1) {
						$textDest = $textDest.' e <span id=<"p'.$dest[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$dest[0].' '.$dest[1].'</span>';
						$textDest = $textDest.'<div id="pop_p'.$dest[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
						<h3>'.$dest[0].' '.$dest[1].'</h3>
								<p>'.get_Bio($dest[2], $conn).'</p>';
						$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$dest[2]);
						if ($qBio->num_rows != 0) {
							$textDest = $textDest.'<p><a href="./presentazione.php?persona='.$dest[2].'" target="_blank">Vai alla presentazione</a>.<p>';
						};
						$qBio->free_result();
						if ($dest[3] != NULL) {
							$textDest = $textDest.'<p><a href="'.$dest[3].'" target="_blank">Vai alla biografia esterna</a>.<p>';
						};
						$textDest = $textDest.'</div>';
					} else {
						$textDest = $textDest.' <span id="p'.$dest[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$dest[0].' '.$dest[1].'</span>,';
						$textDest = $textDest.'<div id="pop_"p'.$dest[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
						<h3>'.$dest[0].' '.$dest[1].'</h3>
							<p>'.get_Bio($dest[2], $conn).'</p>';
						$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$dest[2]);
						if ($qBio->num_rows != 0) {
							$textDest = $textDest.'<p><a href="./presentazione.php?persona='.$dest[2].'" target="_blank">Vai alla presentazione</a>.<p>';
						};
						$qBio->free_result();
						if ($dest[3] != NULL) {
							$textDest = $textDest.'<p><a href="'.$dest[3].'" target="_blank">Vai alla biografia esterna</a>.<p>';
						};
						$textDest = $textDest.'</div>';
					};
				};
			};
		};
		$q2->free_result();
		return $textDest;
	};

	// Funzione per raccogliere i mandanti
	function get_Mandanti ($tipo, $idscopo, $conn) {
		$textMand = "";
		$q3 = $conn->query('SELECT nome, cognome, id, uri FROM mandante, Persona WHERE id = persona AND scopo = '.$idscopo);
		$k = $q3->num_rows;
		if ($k > 0) {
			$textMand = $textMand.' per conto di ';
			if ($k == 1) {
				$mand = $q3->fetch_row();
				$textMand = $textMand.'<span id="p'.$mand[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$mand[0].' '.$mand[1].'</span>';
				$textMand = $textMand.'<div id="pop_p'.$mand[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
						<h3>'.$mand[0].' '.$mand[1].' '.get_Vita($mand[2], $conn).'</h3>
								<p>'.get_Bio($mand[2], $conn).'</p>';
				$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$mand[2]);
				if ($qBio->num_rows != 0) {
					$textDest = $textDest.'<p><a href="./presentazione.php?persona='.$mand[2].'" target="_blank">Vai alla presentazione</a>.<p>';
				};
				$qBio->free_result();
				if ($mand[3] != NULL) {
					$textMand = $textMand.'<p><a href="'.$mand[3].'" target="_blank">Vai alla biografia esterna</a>.<p>';
				};
				$textMand = $textMand.'</div>';
			} else {
				for ($count = 0; $count < $k; $count++) {
					$mand = $q3->fetch_row();
					if ($count == $k-1) {
						$textMand = $textMand.' e <span id="p'.$mand[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$mand[0].' '.$mand[1].'</span>';
					$textMand = $textMand.'<div id="pop_p'.$mand[2].'over" class="popover_content">
									<div class="popover_close" onclick="pop_out(this)">X</div>
							<h3>'.$mand[0].' '.$mand[1].' '.get_Vita($mand[2], $conn).'</h3>
									<p>'.get_Bio($mand[2], $conn).'</p>';
					$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$mand[2]);
					if ($qBio->num_rows != 0) {
						$textDest = $textDest.'<p><a href="./presentazione.php?persona='.$mand[2].'" target="_blank">Vai alla presentazione</a>.<p>';
					};
					$qBio->free_result();
					if ($mand[3] != NULL) {
						$textMand = $textMand.'<p><a href="'.$mand[3].'" target="_blank">Vai alla biografia esterna</a>.<p>';
					};
					$textMand = $textMand.'</div>';
					} else {
						$textMand = $textMand.' <span id="p'.$mand[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$mand[0].' '.$mand[1].'</span>,';
						$textMand = $textMand.'<div id="pop_p'.$mand[2].'over" class="popover_content">
										<div class="popover_close" onclick="pop_out(this)">X</div>
								<h3>'.$mand[0].' '.$mand[1].' '.get_Vita($mand[2], $conn).'</h3>
										<p>'.get_Bio($mand[2], $conn).'</p>';
						$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$mand[2]);
						if ($qBio->num_rows != 0) {
							$textDest = $textDest.'<p><a href="./presentazione.php?persona='.$mand[2].'" target="_blank">Vai alla presentazione</a>.<p>';
						};
						$qBio->free_result();
						if ($mand[3] != NULL) {
							$textMand = $textMand.'<p><a href="'.$mand[3].'" target="_blank">Vai alla biografia esterna</a>.<p>';
						};
						$textMand = $textMand.'</div>';
					};
				};
			};
		};
		$q3->free_result();
		return $textMand;
	};

	// Funzione che prende nascita e morte di una persona
	function get_Vita($idpersona, $conn) {
		$q = $conn->query('SELECT data_nascita, data_morte FROM Persona WHERE id = '.$idpersona);
		$res = $q->fetch_row();
		$dn = "";
		if ($res[0] == NULL) {
			$dn = "?";
		} else {
			$dn = intval(substr($res[0], 0, 4));
		};
		$dm = "";
		if ($res[1] == NULL) {
			$dm = "?";
		} else {
			$dm = intval(substr($res[1], 0, 4));
		};
		return ("(".$dn."-".$dm.")");
	};

	// Funzione che prende i dati di una persona
	function get_Bio($idpersona, $conn) {
		$textBio = "";
		$q = $conn->query('SELECT nome, cognome, luogo_nascita, data_nascita, luogo_morte, data_morte, soprannome FROM Persona WHERE id = '.$idpersona);
		$dati = $q->fetch_row();
		$textBio = $textBio.'<p>'.$dati[0].' '.$dati[1].'';
		if ($dati[3] != NULL || $dati[5] != NULL) {
			$textBio = $textBio.' (';
			if ($dati[3] != NULL && $dati[5] == NULL) {
				$textBio = $textBio.'n.  ';
				if ($dati[2] != NULL) {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[2]);
					$luogoPop = $q->fetch_row;
					$textBio = $textBio.$luogoPop[0].', ';
				};
				$textBio = $textBio.get_Data($dati[3], false);
			} elseif ($dati[3] == NULL && $dati[5] != NULL) {
				$textBio = $textBio.'???  ';
				if ($dati[4] != NULL) {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[4]);
					$luogoPop = $q->fetch_row();
					$textBio = $textBio.$luogoPop[0].', ';
				};
				$textBio = $textBio.get_Data($dati[5], false);
			} else {
				if ($dati[2] != NULL) {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[2]);
					$luogoPop = $q->fetch_row();
					$textBio = $textBio.$luogoPop[0].', ';
				};
				$textBio = $textBio.get_Data($dati[3], false).' - ';
				if ($dati[4] != NULL) {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[4]);
					$luogoPop = $q->fetch_row();
					$textBio = $textBio.$luogoPop[0].', ';
				};
				$textBio = $textBio.get_Data($dati[5], false);
			};
			$textBio = $textBio.')';
		} else {
			if ($dati[2] != NULL || $dati[4] != NULL) {
				$textBio = $textBio.' (';
				if ($dati[2] != NULL && $dati[4] == NULL) {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[2]);
					$luogoPop = $q->fetch_row();
					$textBio = $textBio.'nato a '.$luogoPop[0];
				} elseif ($dati[2] == NULL && $dati[4] != NULL) {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[4]);
					$luogoPop = $q->fetch_row();
					$textBio = $textBio.'morto a '.$luogoPop[0];
				} elseif ($dati[2] == $dati[4]) {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[2]);
					$luogoPop = $q->fetch_row();
					$textBio = $textBio.'nato e morto a '.$luogoPop[0];
				} else {
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[2]);
					$luogoPopN = $q->fetch_row();
					$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$dati[4]);
					$luogoPopM = $q->fetch_row();
					$textBio = $textBio.'nato a '.$luogoPopN[0].' e morto a '.$luogoPopM[0];
				};
				$textBio = $textBio.')';
			};
		};
		if ($dati[6] != NULL) {
			$textBio = $textBio.', conosciuto anche come '.$dati[6].',';
		};
		$textBio = $textBio.' fu:</p>';
		$q->free_result();
		$textBio = $textBio."<ul>";
		$q = $conn->query('SELECT attivita, data_inizio, data_fine FROM lavora_come, Occupazione WHERE occupazione = Occupazione.id AND persona = '.$idpersona);
		$totlavo = $q->num_rows;
		for ($l = 0; $l < $totlavo; $l++) {
			$lavo = $q->fetch_row();
			$textBio = $textBio.'<li>'.$lavo[0];
			if ($lavo[1] != NULL && $lavo[2] != NULL) {
				$di = get_Data($lavo[1], False);
				$df = get_Data($lavo[2], False);
				if ($di == $df) {
					$textBio = $textBio.' (in '.$di.')';
				} else {
					$textBio = $textBio.' (da '.$di.' a '.$df.')';
				};
			};
			$textBio = $textBio.'.</li>';
		};
		$q->free_result();
		$textBio = $textBio.'<ul>';
		return $textBio;
	};
?>
