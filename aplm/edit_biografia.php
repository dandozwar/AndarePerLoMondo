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
	if (isset($_GET["persona"])) {
		$q = $conn->prepare('SELECT persona FROM Biografia WHERE persona = ?');
		$q->bind_param("s", $_GET["persona"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($persona);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('pr', 'de', 'v1', 'v2', 'pu');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_biografia.php?persona=".$persona);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';

	// Raccolta dati biografia
	$q = $conn->query('SELECT * FROM Biografia WHERE persona='.$persona);
	$biog = $q->fetch_row();
	// Raccolta dati persona
	$q = $conn->query('SELECT * FROM Persona WHERE id='.$persona);
	$pers = $q->fetch_row();
	// Check autorizzazione alla modifica
	if ($_SESSION["nick"] != $pers[11]) {
		header("Location: index.php");
	};
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
		<script type="module" src="./js/edit_biografia_init.js"></script>
		<script src="./js/edit_biografia.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di una biografia"/>
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
							<li><a href="./pagina_personale.php?user='.$pers[11].'">Pagina personale</a></li>
							<li><a href="./edit_persona.php?id='.$persona.'">Modifica persona</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica biografia</li>';
					} else {
						echo '<li><a href="edit_biografia.php?persona='.$persona.'">Modifica biografia</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						if ($biog[4] != null) {
							$qv = $conn->query('SELECT titolo FROM Viaggio WHERE id='.$biog[4]);
							$viag = $qv->fetch_row();
							$viaggio_1 = $viag[0];
						} else {
							$viaggio_1 = "da inserire";
						};
						if ($biog[5] != null) {
							$qv = $conn->query('SELECT titolo FROM Viaggio WHERE id='.$biog[5]);
							$viag = $qv->fetch_row();
							$viaggio_2 = $viag[0];
						} else {
							$viaggio_2 = "da inserire";
						};
						echo '<h1>Modifica della biografia</h1>
							<div>
								<h2>Dati fondamentali</h2>
								<table>
									<tr><th>Persona:</th><td>'.$pers[1].' '.$pers[2].'</td><td></td></tr>
									<tr><th>Presentazione:</th><td><input type="text" disabled value="'.$biog[2].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'pr\')"/></td></tr>
									<tr><th>Descrizione:</th><td><input type="textarea" disabled value="'.$biog[3].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'de\')"/></td></tr>
								</table>
							</div>';
							if ($biog[2] != null && $biog[3] != null) {
								echo '<div>
										<h2>Altri dati</h2>
										<table>
											<tr><th>Viaggio 1:</th><td><input type="text" disabled value="'.$viaggio_1.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'v1\')"/></td></tr>
											<tr><th>Viaggio 2:</th><td><input type="text" disabled value="'.$viaggio_2.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'v2\')"/></td></tr>
											<tr><th>Pubblico:</th><td><input type="text" disabled value="';
							if ($biog[6] == 0) {
								echo 'Privato';
							} else {
								echo 'Pubblico';
							};
						echo '"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'pu\')"/></td></tr>
										</table>
									</div>
								<div>
									<h2>Eventi</h2>';
								$qev = $conn->query('SELECT id, titolo, data_inizio, data_fine FROM Evento WHERE biografia = '.$biog[0]);
								$toteven = $qev->num_rows;
								if ($toteven == 0) {
									echo '<p>Nessun evento inserito fin ora.</p>';
								} else {
									echo '<ul>';
									for ($ev = 0; $ev < $toteven; $ev++) {
										$even = $qev->fetch_row();
										echo '<li>'.$even[1].' ('.get_Data($even[2], null, False);
										if ($even[3] != null) {
											echo '-'.get_Data($even[3], null, False);
										}
										echo ')<input class="interact" type="button" value="&#9998;" onclick="modifica_evento('.$even[0].')"/>
											<input class="interact" type="button" value="X" onclick="elimina_evento('.$even[0].')"/></li>';
									};
									echo '</ul>';
								};
								echo '<input type="button" value="Crea evento" onclick="crea_evento('.$biog[0].')">
								</div>';
							} else {
								echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
							};
						break;
					case 'pr': // Presentazione
						echo '<div>
								<h1>Presentazione della biografia</h1>
								<p>Gli estemi bibliografici della persona.</p>
								<input type="text" maxlength="256" id="pr"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'pr\')"/>
							</div>';
						break;
					case 'de': // Descrizione
						echo '<div>
								<h1>Descrizione della biografia</h1>
								<p>Un paragrafo, più dettagliato della presentazione, che riassume la sua vita della persona.</p>
								<input type="textarea" id="de"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'de\')"/>
							</div>';
						break;
					case 'v1': // Viaggio 1
						echo '<div>
								<h1>Viaggo 1 della biografia</h1>
								<p>Un viaggio molto rappresentativo fra quelli compiuti dalla persona.<br/>Sono selezionabili i viaggi a cui la persona ha partecipato, deve essere diverso da viaggio 2.</p>
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_v1_bio" class="dropdown_content">';
						$q = $conn->query('SELECT Viaggio.id, titolo FROM Viaggio, partecipa_viaggio WHERE viaggio = Viaggio.id AND persona = '.$persona.' ORDER BY COALESCE(data_partenza, data_fine)');
						$totviag = $q->num_rows;
						for ($v = 0; $v < $totviag; $v++) {
							$viag = $q->fetch_row();
							echo '<div><input type="radio" id="v1_'.$viag[0].'" name="v1_bio" value="'.$viag[0].'"> <label for="v1_'.$viag[0].'">'.$viag[1].'</label></div>';
						};
						echo '</div>
								</div>
								<div class="blank_space"></div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$persona.', \'v1\')"/>
							</div>';
						break;
					case 'v2': // Viaggio 2
						echo '<div>
								<h1>Viaggo 2 della biografia</h1>
								<p>Un viaggio rappresentativo, ma meno del primo, fra quelli compiuti dalla persona.<br/>Sono selezionabili i viaggi a cui la persona ha partecipato, deve essere diverso da viaggio 1.</p>
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_v2_bio" class="dropdown_content">';
						$q = $conn->query('SELECT Viaggio.id, titolo FROM Viaggio, partecipa_viaggio WHERE viaggio = Viaggio.id AND persona = '.$persona.' ORDER BY COALESCE(data_partenza, data_fine)');
						$totviag = $q->num_rows;
						for ($v = 0; $v < $totviag; $v++) {
							$viag = $q->fetch_row();
							echo '<div><input type="radio" id="v2_'.$viag[0].'" name="v2_bio" value="'.$viag[0].'"> <label for="v2_'.$viag[0].'">'.$viag[1].'</label></div>';
						};
						echo '</div>
								</div>
								<div class="blank_space"></div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$persona.', \'v2\')"/>
							</div>';
						break;
					case 'pu': // Pubblico
						echo '<div>
							<h1>Visibilità della biografia</h1>
							<p>Se il viaggio è visibile agli altri utenti.</p>
						</div>
						<div class="dropdown">
							<input type="button" value="Scegli dall&#8217;elenco">
							<div id="ddc_tipo_scopo" class="dropdown_content">
								<div><input type="radio" id="si" name="pubblico" value=1><label for="si">Pubblico</label></div>
								<div><input type="radio" id="no" name="pubblico" value=0><label for="no">Privato</label></div>
							</div>
						</div>
						<div class="blank_space"></div>
						<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$persona.', \'pu\')"/>';
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
