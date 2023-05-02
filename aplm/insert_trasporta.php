<!DOCTYPE html>
<?php
	session_start();

	// Stabilisce una connessione con il database
	include 'service/secrecy_vis.php';

	// Controlla se l'utente non è già online
	if (isset($_SESSION["nick"])) {
		$q = $conn->prepare('SELECT password FROM Utente WHERE nick = ?');
		$q->bind_param("s", $_SESSION["nick"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($pass);
		$q->fetch();
		if ($_SESSION["pass"] != $pass || ((time() - $_SESSION["time"]) > 7200)) {
			unset($_SESSION["nick"]);
			unset($_SESSION["pass"]);
			unset($_SESSION["time"]);
			session_destroy();
		} else {
			$_SESSION["time"] = time();
		};
		$q->free_result();
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["id"])) {
		$q = $conn->prepare('SELECT id FROM Tappa WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($tappa);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		} else {
			// Dati tappa
			$q = $conn->query('SELECT * FROM Tappa WHERE id='.$tappa);
			$tapp = $q->fetch_row();
			// Dati viaggio
			$q = $conn->query('SELECT * FROM Viaggio WHERE id='.$tapp[1]);
			$viag = $q->fetch_row();
			// Check autorizzazione alla modifica
			if ($_SESSION["nick"] != $viag[11]) {
				header("Location: index.php");
			};
		};
	} else {
		header("Location: index.php");
	};

	//Include le funzioni
	include 'php/functions_date.php';
?>
<html lang="it">
	<head>
		<meta charset="UTF-8"/>
		<link rel="icon" href="./img/LogoAPLM.png"/>
		<link rel="stylesheet" type="text/css" href="./css/general.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" />
		<link rel="stylesheet" type="text/css" href="./css/dropdown.css" />
		<link rel="stylesheet" type="text/css" href="./css/popover.css" />
		<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="./js/functions_date.js"></script>
		<script src="./js/insert_trasporta.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: aggiungi merce trasportata"/>
		<meta name="author" content="Alessandro Cignoni"/>
	</head>
	<body>
		<header>
			<h1>Andare per lo mondo</h1>
			<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Andare per lo mondo"/></a>
			<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" id="logo2" class="stemmi" title="Laboratorio Cultura Digitale"/></a>
			<ul id = "breadcrumb" class="breadcrumb">
				<?php
					echo '<li><a href="./index.php">Home</a></li>
						<li><a href="./pagina_personale.php?user='.$viag[11].'">Pagina personale</a></li>
						<li><a href="./edit_viaggio.php?id='.$viag[0].'">Modifica viaggio</a></li>
						<li><a href="edit_tappa.php?id='.$tappa.'">Modifica Tappa</a></li>
						<li>Aggiungi merce</li>';
				?>
			</ul>
		</header>
		<div>
			<?php
				echo '<div>
						<h1>Aggiungi merce alla tappa</h1>
						<p>Scegli una merce dall&#8217;elenco, cercala nel database o aggiungine una nuova.</p>
						<table>
							<tr><th>Viaggio:</th><td>'.$viag[1].'</td></tr>
							<tr><th>Tappa in posizione:</th><td>'.$tapp[8].'</td></tr>
						</table>
				</div>
				<div id="pop_merc_tappa">
						<div class="dropdown">
							<input type="button" value="Scegli dall&#8217;elenco">
							<div id="ddc_merc_tappa" class="dropdown_content">';
				$q = $conn->query('SELECT id, tipo, quantita, valore FROM Merce');
				$totmerc = $q->num_rows;
				for ($m = 0; $m < $totmerc; $m++) {
					$merc = $q->fetch_row();
					echo '<div><input type="radio" id="merc'.$merc[0].'" name="merc_tappa" value="'.$merc[0].'"><label for="merc'.$merc[0].'">'.$merc[1].', quantità '.$merc[2].', valore '.$merc[3].'</label></div>';
				};
				echo '</div>
					</div>
					<div class="blank_space"></div>
						<h3>Se non hai trovato quello che cerchi</h3>
						<label for="merc_tappa_search">Cerca nel database:</label>
						</br>
						<input type="text" list="merc_tappa_list" id="merc_tappa_search" name="merc_tappa_search">
						<datalist id="merc_tappa_list">';
				$q = $conn->query('SELECT id, tipo, quantita, valore FROM Merce');
				$totmerc = $q->num_rows;
				for ($m = 0; $m < $totmerc; $m++) {
					$merc = $q->fetch_row();
					echo '<option data-id="'.$merc[0].'" value="'.$merc[1].', quantità '.$merc[2].', valore '.$merc[3].'">';
				};
				echo '</datalist>
						</br>
						<input type="button" value="Seleziona" onclick="merc_search()">
						<input type="text" id="merc_tappa_selected" hidden="hidden">
						<br/><br/><input type="button" value="Inserisci nuova" onclick="apri_insert(this)">
					</div>
					<input type="button" value="Invia" id="invia"  onclick="invia_merce('.$tappa.')"/>';
			?>
		</div>
		</div>
		<footer>
			<div class="credit">
				<p>
					<a href="mailto:alessandro.cignoni@progettohmr.it">Alessandro Cignoni</a> - © 2021-2022<br/>
					Progetto del Laboratorio di Cultura Digitale - Università di Pisa<br/>
					<span style="font-size: small">(Team: V. Casarosa, A. Cignoni, L. Galoppini, S. Salvatori)</span><br/><br/>
					Nato come Tesi Triennale in Informatica Umanistica dell'Univerità di Pisa<br/>
					<span style="font-size: small">(Tesista: A. Cignoni; relatori: L. Galoppini, V. Casarosa; ringraziamenti: M. Grava)</span>
				</p>
				<p>
					<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" class="stemmiFinali" title="Andare per lo mondo"/></a>
					<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" class="stemmiFinali" title="Laboratorio Cultura Digitale"/></a>
					<a href="https://infouma.fileli.unipi.it/" target="_blank"><img src="./img/LogoInfoUma.png" class="stemmiFinali" title="Informatica Umanistica a Pisa"/></a>
					<a href="https://www.unipi.it/" target="_blank"><img src="./img/LogoUniPi.png" class="stemmiFinali" title="Univeristà di Pisa"/></a>
				</p>
			</div>
		</footer>
	</body>
</html>
