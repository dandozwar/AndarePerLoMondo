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
		$q = $conn->prepare('SELECT id FROM Evento WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($evento);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('ti', 'dd', 'di', 'df', 'im', 'uri');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_evento.php?id=".$evento);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';

	// Raccolta dati evento
	$q = $conn->query('SELECT * FROM Evento WHERE id='.$evento);
	$even = $q->fetch_row();
	// Raccolta dati biografia
	$q = $conn->query('SELECT * FROM Biografia WHERE id='.$even[1]);
	$biog = $q->fetch_row();
	// Raccolta dati persona
	$q = $conn->query('SELECT * FROM Persona WHERE id='.$biog[1]);
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
		<script type="module" src="./js/edit_evento_init.js"></script>
		<script src="./js/edit_evento.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di un evento"/>
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
							<li><a href="./edit_persona.php?id='.$biog[1].'">Modifica persona</a></li>
							<li><a href="./edit_biografia.php?persona='.$biog[1].'">Modifica biografia</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica evento</li>';
					} else {
						echo '<li><a href="edit_evento.php?id='.$evento.'">Modifica evento</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						echo '<h1>Modifica dell’evento</h1>
							<div>
								<h2>Dati fondamentali</h2>
								<table>
									<tr><th>Biografia:</th><td>'.$pers[1].' '.$pers[2].'</td><td></td></tr>
									<tr><th>Titolo:</th><td><input type="text" disabled value="'.$even[5].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$evento.', \'ti\')"/></td></tr>
									<tr><th>Didascalia:</th><td><input type="textarea" disabled value="'.$even[6].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$evento.', \'dd\')"/></td></tr>
									<tr><th>Data inizio:</th><td><input type="text" disabled value="'.get_Data($even[3], null, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$evento.', \'di\')"/></td></tr>
								</table>
							</div>';
						if ($even[5] != null && $even[6] != null && $even[3] != null) {
							if ($even[2] != null) {
								$qi = $conn->query('SELECT locazione FROM Immagine WHERE id='.$even[2]);
								$imma = $qi->fetch_row();
								$immagine = substr($imma[0], 13);
							} else {
								$immagine = "da inserire";
							};
							echo '<div>
										<h2>Altri dati</h2>
										<table>
											<tr><th>Data fine:</th><td><input type="text" disabled value="'.get_Data($even[4], null, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$evento.', \'df\')"/></td></tr>
											<tr><th>Immagine:</th><td><input type="text" disabled value="'.$immagine.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$evento.', \'im\')"/></td></tr>
											<tr><th>URI:</th><td><input type="text" disabled value="'.$even[7].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$evento.', \'uri\')"/></td></tr>
										</table>
									</div>
								<div>';
						} else {
							echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
						};
						break;
					case 'ti': // Titolo
						echo '<div>
								<h1>Titolo dell’evento</h1>
								<p>Il titolo dell’evento.</p>
								<input type="text" maxlength="128" id="ti"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$evento.', \'ti\')"/>
							</div>';
						break;
					case 'dd': // Didascalia
						echo '<div>
								<h1>Didascalia dell’evento</h1>
								<p>Un paragrafo che riassume l’evento e l’importanza di questo nella vita della persona.</p>
								<input type="textarea" id="dd"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$evento.', \'dd\')"/>
							</div>';
						break;
					case 'di': // Data inizio
						echo '<div>
								<h1>Data inzio dell’evento</h1>
								<p>Data in cui è avvenuto l’evento nel caso sia puntuale, altrimenti data in cui è iniziato.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra secoli e quarti di secoli.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'di\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'di\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'di\')" <label for="anno">Solo anno</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$evento.', \'di\')"/>
							</div>';
						break;
					case 'df': // Data fine
						echo '<div>
								<h1>Data fine dell’evento</h1>
								<p>Data in cui è terminato l’evento.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra secoli e quarti di secoli.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'df\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'df\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'df\')" <label for="anno">Solo anno</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$evento.', \'df\')"/>
							</div>';
						break;
					case 'im': // Immagine
						echo '<div>
								<h1>Immagine dell’evento</h1>
								<p>Un’immagine rappresentativa dell’evento.<br/> Può essere scelta fra le esistenti o se ne può caricare una nuova.</p>
								<div id="pop_im_even">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_im_even" class="dropdown_content">';
						$qim = $conn->query('SELECT id, locazione, didascalia, provenienza FROM Immagine');
						$totimma = $qim->num_rows;
						for ($im = 0; $im < $totimma; $im++) {
							$imma = $qim->fetch_row();
							echo '<div><input type="radio" id="im'.$imma[0].'" name="im_even" value="'.$imma[0].'"> <label for="im'.$imma[0].'"><img src="'.$imma[1].'" style="max-width: 180px; max-height:180px"><br/>'.$imma[2].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="im_even_search">Cerca nel database:</label>
								</br>
								<input type="text" list="im_even_list" id="im_even_search" name="im_even_search">
								<datalist id="im_even_list">';
						$qim = $conn->query('SELECT id, locazione, didascalia, provenienza FROM Immagine');
						$totimma = $qim->num_rows;
						for ($im = 0; $im < $totimma; $im++) {
							$imma = $qim->fetch_row();
							echo '<option data-id="'.$imma[0].'" value="'.$imma[2].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="imm_search()">
								<input type="text" id="im_even_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuova" onclick="apri_insert(\'im\', this)">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$evento.', \'im\')"/>
							</div>';
						break;
					case 'uri': // URI
						echo '<div>
								<h1>URI dell’evento</h1>
								<p>Il link a un sito autorevole che certifichi le informazioni sull’evento inserite.<br/>In ordine utilizzare il <a href="https://www.treccani.it/enciclopedia/elenco-opere/Dizionario_Biografico" target="_blank">Dizionario Biografico degli italiani</a>, l’<a href="https://www.treccani.it/enciclopedia/" target="_blank">Enciclopedia Treccani</a> o <a href="https://www.wikidata.org/wiki/Wikidata:Main_Page" target="_blank">Wikidata</a></p>
								<input type="text" maxlength="256" id="uri"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$evento.', \'uri\')"/>
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
