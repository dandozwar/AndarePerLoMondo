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
		$q = $conn->prepare('SELECT id FROM Scopo WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($scopo);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('ti', 'su');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_scopo.php?id=".$scopo);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';
	include 'php/functions_fonti.php';

	// Raccolta dati viaggio
	$q = $conn->query('SELECT * FROM Scopo WHERE id='.$scopo);
	$scop = $q->fetch_row();
	// Check autorizzazione alla modifica
	if ($_SESSION["nick"] != $scop[3]) {
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
		<script type="module" src="./js/edit_scopo_init.js"></script>
		<script src="./js/edit_scopo.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di uno scopo"/>
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
							<li><a href="./pagina_personale.php?user='.$scop[3].'">Pagina personale</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica scopo</li>';
					} else {
						echo '<li><a href="edit_scopo.php?id='.$scopo.'">Modifica scopo</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						if ($scop[1] != null) {
							$qts = $conn->query('SELECT * FROM Tipo_Scopo WHERE id='.$scop[1]);
							$tisc = $qts->fetch_row();
							$tipo_sc = $tisc[1];
						} else {
							$tipo_sc = "da inserire";
						};
						echo	'<h1>Modifica dello scopo</h1>
								<div>
									<h2>Dati fondamentali</h2>
									<table>
										<tr><th>Tipo:</th><td><input type="text" disabled value="'.$tipo_sc.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$scopo.', \'ti\')"/></td></tr>
										<tr><th>Successo:</th><td><input type="text" disabled value="';
						if ($scop[2] != null) {
							if ($scop[2] == 0) {
								echo 'non ';
							};
							echo 'riuscito';
						} else {
							echo 'da inserire';
						};
						echo '"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$scopo.', \'su\')"/></td></tr>
									</table>
								</div>';
						if ($scop[1] != null && $scop[2] != null) {
							echo '<div class="other_float overflow">
									<h2>Destinatari / Fruitori</h2>
									<p>Le persone che hanno richiesto che il viaggio fosse compiuto,<br/> ma non hanno partecipato al viaggio.</p>';
							$qd = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte, soprannome FROM Persona, destinatario WHERE persona = Persona.id AND scopo = '.$scopo);
							$totdest = $qd->num_rows;
							if ($totdest == 0) {
								echo '<p>Nessun destinatario o fruitore inserito fin ora.</p>';
							} else {
								echo '<ul>';
								for ($d = 0; $d < $totdest; $d++) {
									$dest = $qd->fetch_row();
									echo '<li>'.$dest[1].' '.$dest[2].' ('.get_Data($dest[3], null, true).'-'.get_Data($dest[4], null, true).')';
									if ($dest[5] != null) {
										echo ', detto '.$dest[5];
									};
									echo '<input class="interact" type="button" value="X" onclick="elimina_destinatario('.$dest[0].', '.$scopo.')"/></li>';
								};
								echo '</ul>';
							};
							echo '<input type="button" value="Nuovo destinatario" onclick="crea_destinatario('.$scopo.')">
									</div>
									<div class="other_float overflow">
										<h2>Mandanti / Committenti</h2>
										<p>Le persone a cui lo scopo del viaggio si rivolgeva.</p>';
							$qm = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte, soprannome FROM Persona, mandante WHERE persona = Persona.id AND scopo = '.$scopo);
							$totmand = $qm->num_rows;
							if ($totmand == 0) {
								echo '<p>Nessun mandante o committente inserito fin ora.</p>';
							} else {
								echo '<ul>';
								for ($m = 0; $m < $totmand; $m++) {
									$mand = $qm->fetch_row();
									echo '<li>'.$mand[1].' '.$mand[2].' ('.get_Data($mand[3], null, true).'-'.get_Data($mand[4], null, true).')';
									if ($mand[5] != null) {
										echo ', detto '.$mand[5];
									};
									echo '<input class="interact" type="button" value="X" onclick="elimina_mandante('.$mand[0].', '.$scopo.')"/></li>';
								};
								echo '</ul>';
							};
							echo '<input type="button" value="Nuovo mandante" onclick="crea_mandante('.$scopo.')">
									</div>
									<div class="stop_float"></div>';
						} else {
							echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
						};
						break;
					case 'ti': // Tipo scopo
						echo '<div>
								<h1>Tipo dello scopo</h1>
								<p>Scegli un tipo di scopo dall&#8217;elenco, cercalo nel database o creane uno nuovo.</p>
						</div>
						<div id="pop_tipo_scopo">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_tipo_scopo" class="dropdown_content">';
						$q = $conn->query('SELECT id, tipo FROM Tipo_Scopo ORDER BY tipo');
						$tottisc = $q->num_rows;
						for ($t = 0; $t < $tottisc; $t++) {
							$tisc = $q->fetch_row();
							echo '<div><input type="radio" id="tisc'.$tisc[0].'" name="tipo_scopo" value="'.$tisc[0].'"><label for="tisc'.$tisc[0].'">'.$tisc[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="tipo_scopo_search">Cerca nel database:</label>
								</br>
								<input type="text" list="tipo_scopo_list" id="tipo_scopo_search" name="occu_pers_search">
								<datalist id="tipo_scopo_list">';
						$q = $conn->query('SELECT id, tipo FROM Tipo_Scopo ORDER BY tipo');
						$tottisc = $q->num_rows;
						for ($t = 0; $t < $tottisc; $t++) {
							$tisc = $q->fetch_row();
							echo '<option data-id="'.$tisc[0].'" value="'.$tisc[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="tipo_search()">
								<input type="text" id="tipo_scopo_selected" hidden="hidden">
								<br/><br/><input type="button" value="Inserisci nuovo" onclick="apri_insert(this)">
								<br/><br/>
							</div>
							<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$scopo.', \'ti\')"/>';
						break;
					case 'su': // Successo
						echo '<div>
							<h1>Succsso dello scopo</h1>
							<p>Se lo scopo è stato raggiunto o meno.</p>
						</div>
						<div class="dropdown">
							<input type="button" value="Scegli dall&#8217;elenco">
							<div id="ddc_tipo_scopo" class="dropdown_content">
								<div><input type="radio" id="si" name="successo" value=1><label for="si">Riuscito</label></div>
								<div><input type="radio" id="no" name="successo" value=0><label for="no">Non riuscito</label></div>
							</div>
						</div>
						<div class="blank_space"></div>
						<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$scopo.', \'su\')"/>';
						break;
					default:
						header("Location: index.php");
						break;
				};
			?>
		</div>
		<footer>
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
