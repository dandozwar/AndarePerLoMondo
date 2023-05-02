<?php
	// Funzione di gestione della data
	function get_Fonte ($lista_campi) {
		$fonte = "";
		$lista_compatta = array();
		for ($e = 1; $e < count($lista_campi) - 1; $e++) {
			if ($lista_campi[$e] != "") {
				$lista_compatta[] = $lista_campi[$e];
			};
		};
		$fonte = implode(', ', $lista_compatta);
		return $fonte;
	};
?>
