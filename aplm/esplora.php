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
	};

	// Include le funzioni
	include 'php/functions_date.php';
	include 'php/functions_fonti.php';
?>
<html lang="it">
	<head>
		<meta charset="UTF-8"/>
		<link rel="icon" href="./img/LogoAPLM.png"/>
		<link rel="stylesheet" type="text/css" href="./css/general.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" />
		<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="./js/functions_date.js"></script>
		<script src="./js/esplora.js"></script>
		<script type="module" src="./js/esplora_init.js"></script>
		<script src="./js/accedi.js"></script>
		<script src="./js/background.js"></script>
		<title>APLM - Esplora</title>
		<meta name="author" content="Alessandro Cignoni"/>
		<meta name="description" content="Andare per lo mondo: viaggi messi a confronto"/>
	</head>
	<body>
		<header>
			<h1>Andare per lo mondo</h1>
				<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Andare per lo mondo"/></a>
				<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" id="logo2" class="stemmi" title="Laboratorio Cultura Digitale"/></a>
			<ul id = "breadcrumb" class="breadcrumb">
				<?php
					if (isset($_SESSION["nick"])) {
						echo '<input class="login" type="button" id="pagina_personale" value="Pagina personale" onclick="window.location.assign(\'pagina_personale.php?user='.$_SESSION["nick"].'\')"><input class="login" type="button" id="esci" value="Esci" onclick="esci()"/>';
					} else {
						echo '<input class="login" type="button" id="accedi" value="Accedi o registrati" onclick="accedi_registrati()"/>';
					};
				?>
			</ul>
		</header>
		<div>
			<h2>Seleziona viaggi</h2>
			<button onclick="check_all(true)">Seleziona tutti</button>
			<button onclick="check_all(false)">Deseleziona tutti</button>
			<?php
				$q = $conn->query('SELECT DISTINCT Persona.id, nome, cognome FROM partecipa_viaggio, Persona, Biografia WHERE Persona.id = partecipa_viaggio.persona AND Persona.id = Biografia.persona AND pubblico = 1 ORDER BY COALESCE(Persona.data_nascita, Persona.data_morte)');
				$totpers = $q->num_rows;
				$persone = array();
				for ($p = 0; $p < $totpers; $p++) {
					$pers = $q->fetch_row();
					array_push($persone, $pers);
				};
				$q->free_result();
				echo '<form>';
				echo '<table>';
				echo '<tr><th>Persona</th><th>Viaggi</th></tr>';
				$viaggi_usati = array();
				for ($p = 0; $p < $totpers; $p++) {
					echo '<tr>';
					echo '<td><a href="./presentazione.php?persona='.$persone[$p][0].'">'.$persone[$p][1].' '.$persone[$p][2].'</a></td>';
					$q = $conn->query('SELECT id, titolo, data_partenza, data_fine, fonte, pagine, intervallo_partenza, intervallo_fine FROM Viaggio, partecipa_viaggio WHERE id = viaggio AND persona ='.$persone[$p][0].' AND pubblico = 1 ORDER BY data_partenza, id');
					$totviag = $q->num_rows;
					echo '<td><ul style="list-style-type:none;">';
					for ($v = 0; $v < $totviag; $v++) {
						$viag = $q->fetch_row();
						$viaggi_usati[] = $viag[0];
						if ($viag[6] != NULL) {
							$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$viag[6]);
							$inter = $q->fetch_row();
							$viag[6] = $inter[0];
							$q->free_result();
						};
						if ($viag[7] != NULL) {
							$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$viag[7]);
							$inter = $q->fetch_row();
							$viag[7] = $inter[0];
							$q->free_result();
						};
						$dp_anno = get_Data($viag[2], $viag[6], True);
						$df_anno = get_Data($viag[3], $viag[7], True);
						echo '<li><input type="checkbox" id="v'.$viag[0].'_'.$v.'" name="v'.$viag[0].'_'.$v.'" value="'.$viag[0].'" onclick="tick_on(this)">';
						echo '<label for="v'.$viag[0].'">';
						if ($dp_anno == $df_anno) {
							echo $viag[1].' ('.$dp_anno.')';
						} else {
							echo $viag[1].' ('.$dp_anno.'-'.$df_anno.')';
						};
						echo ' [<a href="#'.$viag[4].'">'.$viag[4].'</a>';
						if ($viag[5] != NULL) {
							echo ' '.$viag[5];
						};
						echo '].';
						echo '</label>';
						$q2 = $conn->query('SELECT nome, cognome, id FROM Persona, partecipa_viaggio WHERE viaggio = '.$viag[0].' AND id = persona AND id <> '.$persone[$p][0]);
						$totpart = $q2->num_rows;
						if ($totpart != 0) {
							echo '<br/>Altri partecipanti: ';
							for ($pt = 0; $pt < $totpart - 1; $pt++) {
								$part = $q2->fetch_row();
								echo $part[0].' '.$part[1].', ';
							};
							$part = $q2->fetch_row();
							echo $part[0].' '.$part[1].'.';
						};
						echo '</li>';
					};
					echo '</ul></td>';
					echo '</tr>';
				};
				$stringa_usati = implode(', ', $viaggi_usati);
				$qr = $conn->query('SELECT id, titolo, data_partenza, data_fine, fonte, pagine, intervallo_partenza, intervallo_fine FROM Viaggio WHERE id NOT IN ('.$stringa_usati.') AND pubblico = 1 ORDER BY data_partenza');
				$totnon = $qr->num_rows;
				if ($totnon != 0) {
					echo '<tr><td>Altri</td><td><ul style="list-style-type:none;">';
					for ($v = 0; $v < $totnon; $v++) {
						$viag = $qr->fetch_row();
						if ($viag[6] != NULL) {
							$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$viag[6]);
							$inter = $q->fetch_row();
							$viag[6] = $inter[0];
							$q->free_result();
						};
						if ($viag[7] != NULL) {
							$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$viag[7]);
							$inter = $q->fetch_row();
							$viag[7] = $inter[0];
							$q->free_result();
						};
						$dp_anno = get_Data($viag[2], $viag[6], True);
						$df_anno = get_Data($viag[3], $viag[7], True);
						echo '<li><input type="checkbox" id="v'.$viag[0].'_'.$v.'" name="v'.$viag[0].'_'.$v.'" value="'.$viag[0].'" onclick="tick_on(this)">';
						echo '<label for="v'.$viag[0].'">';
						if ($dp_anno == $df_anno) {
							echo $viag[1].' ('.$dp_anno.')';
						} else {
							echo $viag[1].' ('.$dp_anno.'-'.$df_anno.')';
						};
						echo ' [<a href="#'.$viag[4].'">'.$viag[4].'</a>';
						if ($viag[5] != NULL) {
							echo ' '.$viag[5];
						};
						echo '].';
						echo '</label>';
						$q2 = $conn->query('SELECT nome, cognome, id FROM Persona, partecipa_viaggio WHERE viaggio = '.$viag[0].' AND id = persona');
						$totpart = $q2->num_rows;
						if ($totpart != 0) {
							echo '<br/>Partecipanti: ';
							for ($pt = 0; $pt < $totpart - 1; $pt++) {
								$part = $q2->fetch_row();
								echo $part[0].' '.$part[1].', ';
							};
							$part = $q2->fetch_row();
							echo $part[0].' '.$part[1].'.';
						};
						echo '</li>';
					};
					echo '</ul><td></tr>';
				};
				echo '</table>';
				echo '</form>';
			?>
			<button onclick="show_Viaggi()">Visualizza viaggi</button>
			<p>Clicca <a href="./service/scarica.php">qui</a> per scaricare tutti i viaggi.<br/>Il file è un GeoJSON, direttamente importabile su QGIS.</p>
		</div>
		<div id="map"  class="map start_float"></div>
		<div class="start_float">
			<h2>Legenda</h2>
			<ul id="legenda">
			</ul>
		</div>
		<div class="stop_float">
			<p>
				<h3>Note</h3>
				<ul>
					<?php
						$q = $conn->query('SELECT DISTINCT Fonte.id, autore, Fonte.titolo, titolo_volume, titolo_rivista, numero, curatore, luogo, editore, nome_sito, anno, collana, Fonte.pagine, url, Fonte.schedatore FROM Fonte, Viaggio WHERE fonte = Fonte.id AND pubblico = 1 ORDER BY Fonte.id');
						$totfont = $q->num_rows;
						for ($f = 0; $f < $totfont; $f++) {
							$font = $q->fetch_row();
							echo '<li id="'.$font[0].'">['.$font[0].']'.get_Fonte($font).'</li>';
						};
					?>
				</ol>
			</p>
		</div>
		<footer>
			<div id="access_panel" hidden="hidden">
				<div id="log_in">
					<div class="close" onclick="stop_accedi()">X</div>
					<form id="log_in_form">
						<label for="nick">Nickname:</label><br/>
						<input type="text" id="nick" name="nick"></input><br/><br/>
						<label for="pass">Password:</label><br/>
						<input type="password" id="pass" name="pass"></input><br/><br/>
						<input type="button" onclick="conferma_accesso()" value="Accedi"></input>
					</form>
					<p> Non sei un utente registrato? <br/>
						<button onclick="registrati()">Registrati</button>
					</p>
				</div>
				<div id="sign_up" hidden="hidden">
					<div class="close" onclick="stop_accedi()">X</div>
					<form id="sign_up_form">
						<label for="nick">Nickname:</label><br/>
						<input type="text" id="nick" name="nick" placeholder="Min 3 caratteri, max 16."></input><br/><br/>
						<label for="pass">Password:</label><br/>
						<input type="password" id="pass" name="pass" placeholder="Max 3 caratteri, max 16."></input><br/><br/>
						<label for="nome">Nome:</label><br/>
						<input type="text" id="nome" name="nome"></input><br/><br/>
						<label for="cognome">Cognome:</label><br/>
						<input type="text" id="cognome" name="cognome"></input><br/><br/>
						<label for="ente">Ente in cui lavora:</label><br/>
						<input type="text" id="ente" name="ente"></input><br/><br/>
						<label for="ruolo">Ruolo che ricopre:</label><br/>
						<input type="text" id="ruolo" name="ruolo"></input><br/><br/>
						<input type="button" onclick="conferma_registrati()" value="Registrati"></input>
					</form>
				</div>
			</div>
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
