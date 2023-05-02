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
		$q = $conn->prepare('SELECT id FROM relazione WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($relazione);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('p2', 'ti', 'di', 'df');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_relazione.php?id=".$relazione);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';

	// Raccolta dati biografia
	$q = $conn->query('SELECT * FROM relazione WHERE id='.$relazione);
	$rela = $q->fetch_row();
	// Raccolta dati persona
	$q = $conn->query('SELECT * FROM Persona WHERE id='.$rela[1]);
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
		<script type="module" src="./js/edit_relazione_init.js"></script>
		<script src="./js/edit_relazione.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di una relazione"/>
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
						echo '<li>Modifica relazione</li>';
					} else {
						echo '<li><a href="edit_relazione.php?id='.$relazione.'">Modifica relazione</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						if ($rela[2] != null) {
							$qp2 = $conn->query('SELECT nome, cognome FROM Persona WHERE id='.$rela[2]);
							$per2 = $qp2->fetch_row();
							$persona_2 = $per2[0].' '.$per2[1];
						} else {
							$persona_2 = "da inserire";
						};
						if ($rela[3] != null) {
							$qtr = $conn->query('SELECT tipo FROM Tipo_Relazione WHERE id='.$rela[3]);
							$tira = $qtr->fetch_row();
							$tipo_rela = $tira[0];
						} else {
							$tipo_rela = "da inserire";
						};
						if ($rela[6] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$rela[6]);
							$inte = $qi->fetch_row();
							$int_iniz = $inte[0];
						} else {
							$int_iniz = "da inserire";
						};
						if ($rela[7] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$rela[7]);
							$inte = $qi->fetch_row();
							$int_fine = $inte[0];
						} else {
							$int_fine = "da inserire";
						};
						echo '<h1>Modifica della relazione</h1>
							<div>
								<h2>Dati fondamentali</h2>
								<table>
									<tr><th>Persona 1:</th><td>'.$pers[1].' '.$pers[2].'</td><td></td></tr>
									<tr><th>Tipo relazione:</th><td><input type="text" disabled value="'.$tipo_rela.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$relazione.', \'ti\')"/></td></tr>
									<tr><th>Persona 2:</th><td><input type="text" disabled value="'.$persona_2.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$relazione.', \'p2\')"/></td></tr>
								</table>
							</div>';
						if ($rela[2] != null && $rela[3] != null) {
							echo '<div>
									<h2>Altri dati</h2>
									<table>
										<tr><th>Data inizio:</th><td><input type="text" disabled value="'.get_Data($rela[4], $int_iniz, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$relazione.', \'di\')"/></td></tr>
										<tr><th>Data fine:</th><td><input type="text" disabled value="'.get_Data($rela[5], $int_fine, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$relazione.', \'df\')"/></td></tr>
									</table>
								</div>';
						} else {
							echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
						};
						break;
					case 'p2': // Persona 2
						echo '<div>
								<h1>Persona 2 della relazione</h1>
								<p>La persona che subisce il tipo della relazione.</p>
								<h3>Attenzione!</h3>
								<p>Se vuoi inserire una nuova persona dovrai farlo dalla tua <a href="./pagina_personale.php?user='.$pers[11].'">pagina personale</a>.</p>
								<div id="pers2_rela">
									<div class="dropdown">
										<input type="button" value="Scegli dall&#8217;elenco">
										<div id="ddc_p2_rela" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome, cognome FROM Persona WHERE id != '.$rela[1].' ORDER BY COALESCE(data_nascita, data_morte)');
						$totpers = $q->num_rows;
						for ($p = 0; $p < $totpers; $p++) {
							$pers = $q->fetch_row();
							echo '<div><input type="radio" id="p2'.$pers[0].'" name="p2_rela" value="'.$pers[0].'"> <label for="p2'.$pers[0].'">'.$pers[1].' '.$pers[2].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="p2_rela_search">Cerca nel database:</label>
								</br>
								<input type="text" list="p2_rela_list" id="p2_rela_search" name="p2_rela_search">
								<datalist id="p2_rela_list">';
						$q = $conn->query('SELECT id, nome, cognome FROM Persona WHERE id != '.$rela[1].' ORDER BY COALESCE(data_nascita, data_morte)');
						$totpers = $q->num_rows;
						for ($p = 0; $p < $totpers; $p++) {
							$pers = $q->fetch_row();
							echo '<option data-id="'.$pers[0].'" value="'.$pers[1].' '.$pers[2].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="pers_search()">
								<input type="text" id="p2_rela_selected" hidden="hidden">
							<br/><br/><input type="button" value="Invia" id="invia"  onclick="invia_campo('.$relazione.', \'p2\')"/>
							</div>';
						break;
					case 'ti': // Tipo Relazione
						echo '<div>
							<h1>Tipo della relazione</h1>
							<p>Scegli un tipo dall&#8217;elenco, cercalo nel database o creane uno nuovo.</p>
						<div id="pop_tipo_rela">
							<div class="dropdown">
								<input type="button" value="Scegli dall&#8217;elenco">
								<div id="ddc_tipo_rela" class="dropdown_content">';
						$q = $conn->query('SELECT id, tipo FROM Tipo_Relazione ORDER BY tipo');
						$tottire = $q->num_rows;
						for ($t = 0; $t < $tottire; $t++) {
							$tire = $q->fetch_row();
							echo '<div><input type="radio" id="tr'.$tire[0].'" name="tipo_rela" value="'.$tire[0].'"><label for="tr'.$tire[0].'">'.$tire[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="tipo_rela_search">Cerca nel database:</label>
								</br>
								<input type="text" list="tipo_rela_list" id="tipo_rela_search" name="tipo_rela_search">
								<datalist id="tipo_rela_list">';
						$q = $conn->query('SELECT id, tipo FROM Tipo_Relazione ORDER BY tipo');
						$tottire = $q->num_rows;
						for ($t = 0; $t < $tottire; $t++) {
							$tire = $q->fetch_row();
							echo '<option data-id="'.$tire[0].'" value="'.$tire[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="tipo_search()">
								<input type="text" id="tipo_rela_selected" hidden="hidden">
								<br/><br/><input type="button" value="Inserisci nuovo" onclick="apri_insert(this)">
								<br/><br/>
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$relazione.', \'ti\')"/>
							<div>';
						break;
					case 'di': // Data inizio
						echo '<div>
								<h1>Data inizio della relazione</h1>
								<p>Data in cui la relazione è iniziata.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra metà di secoli e quarti di secoli.</p>
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
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$relazione.', \'di\')"/>
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
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'df\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$relazione.', \'df\')"/>
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
