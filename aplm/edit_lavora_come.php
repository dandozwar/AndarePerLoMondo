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
		$q = $conn->prepare('SELECT id FROM lavora_come WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($lavora_come);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('oc', 'di', 'df');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_occupazione.php?id=".$lavora_come);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';

	// Raccolta dati biografia
	$q = $conn->query('SELECT * FROM lavora_come WHERE id='.$lavora_come);
	$laco = $q->fetch_row();
	// Raccolta dati persona
	$q = $conn->query('SELECT * FROM Persona WHERE id='.$laco[1]);
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
		<script type="module" src="./js/edit_lavora_come_init.js"></script>
		<script src="./js/edit_lavora_come.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di una occupazione"/>
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
							<li><a href="./edit_persona.php?id='.$pers[0].'">Modifica persona</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica occupazione</li>';
					} else {
						echo '<li><a href="edit_lavora_come.php?id='.$lavora_come.'">Modifica occupazione</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						if ($laco[2] != null) {
							$qtr = $conn->query('SELECT attivita FROM Occupazione WHERE id='.$laco[2]);
							$atti = $qtr->fetch_row();
							$attivita = $atti[0];
						} else {
							$attivita = "da inserire";
						};
						if ($laco[5] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$laco[5]);
							$inte = $qi->fetch_row();
							$int_iniz = $inte[0];
						} else {
							$int_iniz = "da inserire";
						};
						if ($laco[6] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$laco[6]);
							$inte = $qi->fetch_row();
							$int_fine = $inte[0];
						} else {
							$int_fine = "da inserire";
						};
						echo '<h1>Modifica dell’occupazione</h1>
							<div>
								<h2>Dati fondamentali</h2>
								<table>
									<tr><th>Persona:</th><td>'.$pers[1].' '.$pers[2].'</td><td></td></tr>
									<tr><th>Occupazione:</th><td><input type="text" disabled value="'.$attivita.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$lavora_come.', \'oc\')"/></td></tr>
								</table>
							</div>';
						if ($laco[2] != null) {
							echo '<div>
									<h2>Altri dati</h2>
									<table>
										<tr><th>Data inizio:</th><td><input type="text" disabled value="'.get_Data($laco[3], $int_iniz, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$lavora_come.', \'di\')"/></td></tr>
										<tr><th>Data fine:</th><td><input type="text" disabled value="'.get_Data($laco[4], $int_fine, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$lavora_come.', \'df\')"/></td></tr>
									</table>
								</div>';
						} else {
							echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
						};
						break;
					case 'oc': // Occupazione
						echo '<div>
							<h1>Occupazione</h1>
							<p>Scegli un tipo dall&#8217;elenco, cercalo nel database o creane uno nuovo.</p>
						<div id="pop_attivita">
							<div class="dropdown">
								<input type="button" value="Scegli dall&#8217;elenco">
								<div id="ddc_attivita" class="dropdown_content">';
						$q = $conn->query('SELECT id, attivita FROM Occupazione ORDER BY attivita');
						$totatti = $q->num_rows;
						for ($a = 0; $a < $totatti; $a++) {
							$atti = $q->fetch_row();
							echo '<div><input type="radio" id="at'.$atti[0].'" name="attivita" value="'.$atti[0].'"><label for="at'.$atti[0].'">'.$atti[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="attivita_search">Cerca nel database:</label>
								</br>
								<input type="text" list="attivita_list" id="attivita_search" name="attivita_search">
								<datalist id="attivita_list">';
						$q = $conn->query('SELECT id, attivita FROM Occupazione ORDER BY attivita');
						$tottire = $q->num_rows;
						for ($a = 0; $a < $totatti; $a++) {
							$atti = $q->fetch_row();
							echo '<option data-id="'.$atti[0].'" value="'.$atti[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="occu_search()">
								<input type="text" id="attivita_selected" hidden="hidden">
								<br/><br/><input type="button" value="Inserisci nuova" onclick="apri_insert(this)">
								<br/><br/>
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$lavora_come.', \'oc\')"/>
							<div>';
						break;
					case 'di': // Data inizio
						echo '<div>
								<h1>Data inizio della relazione</h1>
								<p>Data in cui la relazione è iniziata.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'di\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'di\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'di\')" <label for="anno">Solo anno</label></div>
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'di\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$lavora_come.', \'di\')"/>
							</div>';
						break;
					case 'df': // Data fine
						echo '<div>
								<h1>Data fine della relazione</h1>
								<p>Data in cui la relazione è finita.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'df\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'df\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'df\')" <label for="anno">Solo anno</label></div>
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'di\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$lavora_come.', \'df\')"/>
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
