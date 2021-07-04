<?php
	// Funzione di gestione della data
	function get_Data ($data, $anno) {
		if ($anno) {
			$data = intval(substr($data, 0, 4));
		} else {
			if (substr($data, 5) == '00-00') {
				$data = intval(substr($data, 0, 4));
			} elseif (substr($data, 8) == '00') {
				$mese = intval(substr($data, 5, 2));
				$mese = char_mese($mese);
				$data = $mese.' '.intval(substr($data, 0, 4));
			} else {
				$mese = intval(substr($data, 5, 2));
				$mese = char_mese($mese);
				$data = intval(substr($data, 8)).' '.$mese.' '.intval(substr($data, 0, 4));
			};
		};
		return $data;
	};

	// Funzione che trasforma il mese da numero a caratteri
	function char_mese($m) {
		$mesi = ['gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno', 'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'];
		switch ($m) {
			case 1: return $mesi[0];
			case 2: return $mesi[1];
			case 3: return $mesi[2];
			case 4: return $mesi[3];
			case 5: return $mesi[4];
			case 6: return $mesi[5];
			case 7: return $mesi[6];
			case 8: return $mesi[7];
			case 9: return $mesi[8];
			case 10: return $mesi[9];
			case 11: return $mesi[10];
			case 12: return $mesi[11];
			default: return 'Errore';
		};
	};
?>
