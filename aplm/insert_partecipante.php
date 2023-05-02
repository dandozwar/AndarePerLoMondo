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
	if (isset($_GET["id"]) && isset($_GET["tipo"])) {
		if ($_GET["tipo"] == 'v') {
			$q = $conn->prepare('SELECT id FROM Viaggio WHERE id = ?');
			$q->bind_param("s", $_GET["id"]);
			$q->execute();
			$q->store_result();
			$q->bind_result($viaggio);
			$q->fetch();
			if ($q->num_rows() == 0) {
				header("Location: index.php");
			} else {
				$flagTipo = 'v';
				// Dati viaggio
				$q = $conn->query('SELECT * FROM Viaggio WHERE id='.$viaggio);
				$viag = $q->fetch_row();			
				// Check autorizzazione alla modifica
				if ($_SESSION["nick"] != $viag[11]) {
					header("Location: index.php");
				};
			};
		} else if ($_GET["tipo"] == 't') {
			$q = $conn->prepare('SELECT id FROM Tappa WHERE id = ?');
			$q->bind_param("s", $_GET["id"]);
			$q->execute();
			$q->store_result();
			$q->bind_result($tappa);
			$q->fetch();
			if ($q->num_rows() == 0) {
				header("Location: index.php");
			} else {
				$flagTipo = 't';
				// Dati tappa
				$q = $conn->query('SELECT * FROM Tappa WHERE id='.$tappa);
				$tapp = $q->fetch_row();
				// Dati viaggio
				$q2 = $conn->query('SELECT * FROM Viaggio WHERE id='.$tapp[1]);
				$viag = $q2->fetch_row();
				// Check autorizzazione alla modifica
				if ($_SESSION["nick"] != $viag[11]) {
					header("Location: index.php");
				};
			};
		} else {
			header("Location: index.php");
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
		<script src="./js/insert_partecipante.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: aggiungi partecipante"/>
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
						<li><a href="./edit_viaggio.php?id='.$viag[0].'">Modifica viaggio</a></li>';
					if ($flagTipo == 't') {
						echo '<li><a href="edit_tappa.php?id='.$tappa.'">Modifica Tappa</a></li>';
					};
					echo '<li>Aggiungi partecipante</li>';
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagTipo) {
					case 'v':
						echo '<div>
								<h1>Aggiungi partecipante al viaggio</h1>
								<p>Scegli un partecipante dall&#8217;elenco o cercalo nel database.<br/><br/>
								<em>Attenzione!</em><br/>Se vuoi inserire una nuova persona dovrai farlo dalla tua <a href="./pagina_personale.php?user='.$viag[11].'">pagina personale</a>.</p>
								<table>
									<tr><th>Viaggio:</th><td>'.$viag[1].'</td></tr>
								</table>
						</div>
						<div id="part_viaggio">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_part_viaggio" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome, cognome FROM Persona ORDER BY COALESCE(data_nascita, data_morte)');
						$totpers = $q->num_rows;
						for ($p = 0; $p < $totpers; $p++) {
							$pers = $q->fetch_row();
							echo '<div><input type="radio" id="part'.$pers[0].'" name="part_viaggio" value="'.$pers[0].'"> <label for="part'.$pers[0].'">'.$pers[1].' '.$pers[2].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="part_viaggio_search">Cerca nel database:</label>
								</br>
								<input type="text" list="part_viaggio_list" id="part_viaggio_search" name="part_viaggio_search">
								<datalist id="part_viaggio_list">';
						$q = $conn->query('SELECT id, nome, cognome FROM Persona ORDER BY COALESCE(data_nascita, data_morte)');
						$totpers = $q->num_rows;
						for ($p = 0; $p < $totpers; $p++) {
							$pers = $q->fetch_row();
							echo '<option data-id="'.$pers[0].'" value="'.$pers[1].' '.$pers[2].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="pers_search(\'v\')">
								<input type="text" id="part_viaggio_selected" hidden="hidden">
							<br/><br/><input type="button" value="Invia" id="invia"  onclick="invia_partecipante(\'v\', '.$viaggio.')"/>
							</div>';
						break;
					case 't':
						echo '<div>
								<h1>Aggiungi partecipante alla tappa</h1>
								<p>Scegli un partecipante dall&#8217;elenco o cercalo nel database.<br/>Non deve già partecipare al viaggio.</p>
								<h3>Attenzione!</h3>
								<p>Se vuoi inserire una nuova persona dovrai farlo dalla tua <a href="./pagina_personale.php?user="'.$viag[11].'">pagina personale</a>.</p></p>
								<table>
									<tr><th>Viaggio:</th><td>'.$viag[1].'</td></tr>
									<tr><th>Tappa in posizione:</th><td>'.$tapp[8].'</td></tr>
								</table>
						</div>
						<div id="part_tappa">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_part_tappa" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome, cognome FROM Persona WHERE id NOT IN (SELECT persona FROM partecipa_viaggio WHERE viaggio = '.$viag[0].') ORDER BY COALESCE(data_nascita, data_morte)');
						$totpers = $q->num_rows;
						for ($p = 0; $p < $totpers; $p++) {
							$pers = $q->fetch_row();
							echo '<div><input type="radio" id="part'.$pers[0].'" name="part_tappa" value="'.$pers[0].'"> <label for="part'.$pers[0].'">'.$pers[1].' '.$pers[2].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="part_tappa_search">Cerca nel database:</label>
								</br>
								<input type="text" list="part_tappa_list" id="part_tappa_search" name="part_tappa_search">
								<datalist id="part_tappa_list">';
						$q = $conn->query('SELECT id, nome, cognome FROM Persona WHERE id NOT IN (SELECT persona FROM partecipa_viaggio WHERE viaggio = '.$viag[0].') ORDER BY COALESCE(data_nascita, data_morte)');
						$totpers = $q->num_rows;
						for ($p = 0; $p < $totpers; $p++) {
							$pers = $q->fetch_row();
							echo '<option data-id="'.$pers[0].'" value="'.$pers[1].' '.$pers[2].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="pers_search(\'t\')">
								<input type="text" id="part_tappa_selected" hidden="hidden">
							<br/><br/><input type="button" value="Invia" id="invia"  onclick="invia_partecipante(\'t\', '.$tappa.')"/>
							</div>';
						break;
					default:
						header("Location: index.php");
						break;
				};
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
