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
		$q = $conn->prepare('SELECT id FROM Fonte WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($fonte);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('au', 'ti', 'tv', 'tr', 'nu', 'cu', 'lu', 'ed', 'ns', 'an', 'co', 'pag', 'url');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_fonte.php?id=".$fonte);
		};
	} else {
		$flagCampo = "base";
	};


	// Raccolta dati evento
	$q = $conn->query('SELECT * FROM Fonte WHERE id='.$fonte);
	$font = $q->fetch_row();
	// Check autorizzazione alla modifica
	if ($_SESSION["nick"] != $font[14]) {
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
		<script src="./js/edit_fonte.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di una fonte"/>
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
							<li><a href="./pagina_personale.php?user='.$font[14].'">Pagina personale</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica fonte</li>';
					} else {
						echo '<li><a href="edit_fonte.php?id='.$fonte.'">Modifica fonte</a></li><li>Modifica ';
						switch ($_GET["campo"]) {
							case 'au':
								echo 'autore';
								break;
							case 'ti':
								echo 'titolo';
								break;
							case 'tv':
								echo 'titolo volume';
								break;
							case 'tr':
								echo 'titolo rivista';
								break;
							case 'nu':
								echo 'numero';
								break;
							case 'cu':
								echo 'curatore';
								break;
							case 'lu':
								echo 'luogo';
								break;
							case 'ed':
								echo 'editore';
								break;
							case 'ns':
								echo 'nome sito';
								break;
							case 'an':
								echo 'anno';
								break;
							case 'co':
								echo 'collana';
								break;
							case 'pag':
								echo 'pagine';
								break;
							case 'url':
								echo 'URL';
								break;
							default:
								echo 'errore!';
								break;
						};
						echo '</li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						echo '<h1>Modifica della fonte</h1>
							<div>
								<p><em>Attenzione!</em><br/>Se vuoi inserire una nuova fonte dovrai farlo durante l\'inserimento di un nuovo viaggio; puoi crearlo dalla tua <a href="./pagina_personale.php?user='.$font[14].'">pagina personale</a>.
								<table>
									<tr><th>Autore:</th><td><input type="text" id="autore" name="autore" maxlength="128" disabled value="'.$font[1].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'au\')"/></td></tr>
									<tr><th>Titolo:</th><td><input type="text" id="titolo" name="titolo" maxlength="128" disabled value="'.$font[2].'"/><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'ti\')"/></td></td></tr>
									<tr><th>Titolo volume:</th><td><input type="text" id="titolo_volume" name="titolo_volume" maxlength="128" disabled value="'.$font[3].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'tv\')"/></td></tr>
									<tr><th>Titolo rivista:</th><td><input type="text" id="titolo_rivista" name="titolo_rivista" maxlength="128" disabled value="'.$font[4].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'tr\')"/></td></tr>
									<tr><th>Numero:</th><td><input type="text" id="numero" name="numero" maxlength="128" disabled value="'.$font[5].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'nu\')"/></td></tr>
									<tr><th>Curatore:</th><td><input type="text" id="curatore" name="curatore" maxlength="128" disabled value="'.$font[6].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'cu\')"/></td></tr>
									<tr><th>Luogo:</th><td><input type="text" id="luogo" name="luogo" maxlength="128" disabled value="'.$font[7].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'lu\')"/></td></tr>
									<tr><th>Editore:</th><td><input type="text" id="editore" name="editore" maxlength="128" disabled value="'.$font[8].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'ed\')"/></td></tr>
									<tr><th>Nome sito:</th><td><input type="text" id="nome_sito" name="nome_sito" maxlength="128" disabled value="'.$font[9].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'ns\')"/></td></tr>
									<tr><th>Anno:</th><td><input type="text" id="anno" name="anno" maxlength="128" disabled value="'.$font[10].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'an\')"/></td></tr>
									<tr><th>Collana:</th><td><input type="text" id="collana" name="collana" maxlength="128" disabled value="'.$font[11].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'co\')"/></td></tr>
									<tr><th>Pagine:</th><td><input type="text" id="pagine" name="pagine" maxlength="128" disabled value="'.$font[12].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'pag\')"/></td></tr>
									<tr><th>URL:</th><td><input type="text" id="url" name="url" maxlength="128" disabled value="'.$font[13].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$fonte.', \'url\')"/></td></tr>
							</table>
							</div>';
						break;
					case 'au': // Autore
						echo '<div>
								<h1>Autore della fonte</h1>
								<p>L\'autore della fonte.</p>
								<input type="text" maxlength="128" id="au"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'au\')"/>
							</div>';
						break;
					case 'ti': // Titolo
						echo '<div>
								<h1>Titolo della fonte</h1>
								<p>Il titolo della fonte.</p>
								<input type="text" maxlength="128" id="ti"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'ti\')"/>
							</div>';
						break;
					case 'tv': // Titolo del volume
						echo '<div>
								<h1>Titolo del volume della fonte</h1>
								<p>Il titolo del volume della fonte.</p>
								<input type="text" maxlength="128" id="tv"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'tv\')"/>
							</div>';
						break;
					case 'tr': // Titolo della rivista
						echo '<div>
								<h1>Titolo della rivista della fonte</h1>
								<p>Il titolo del volume della fonte.</p>
								<input type="text" maxlength="128" id="tr"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'tr\')"/>
							</div>';
						break;
					case 'nu': // Numero
						echo '<div>
								<h1>Numero della fonte</h1>
								<p>Il numero della rivista o della collana della fonte.</p>
								<input type="text" maxlength="128" id="nu"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'nu\')"/>
							</div>';
						break;
					case 'cu': // Curatore
						echo '<div>
								<h1>Curatore della fonte</h1>
								<p>Il curatore dell\'edizione della fonte.</p>
								<input type="text" maxlength="128" id="cu"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'cu\')"/>
							</div>';
						break;
					case 'lu': // Luogo
						echo '<div>
								<h1>Luogo della fonte</h1>
								<p>Il luogo di pubblicazione della fonte.</p>
								<input type="text" maxlength="128" id="lu"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'lu\')"/>
							</div>';
						break;
					case 'ed': // Editore
						echo '<div>
								<h1>Editore della fonte</h1>
								<p>L\'editore della fonte.</p>
								<input type="text" maxlength="128" id="ed"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'ed\')"/>
							</div>';
						break;
					case 'ns': // Nome del sito
						echo '<div>
								<h1>Nome del sito della fonte</h1>
								<p>Il nome del sito della fonte.</p>
								<input type="text" maxlength="128" id="ns"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'ns\')"/>
							</div>';
						break;
					case 'an': // Anno
						echo '<div>
								<h1>Anno della fonte</h1>
								<p>L\'anno di pubblicazione della fonte.</p>
								<input type="text" maxlength="128" id="an"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'an\')"/>
							</div>';
						break;
					case 'co': // Collana
						echo '<div>
								<h1>Collana della fonte</h1>
								<p>La collana della fonte.</p>
								<input type="text" maxlength="128" id="co"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'co\')"/>
							</div>';
						break;
					case 'pag': // Pagine
						echo '<div>
								<h1>Pagine della fonte</h1>
								<p>Le pagine della fonte.</p>
								<input type="text" maxlength="128" id="pag"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'pag\')"/>
							</div>';
						break;
					default:
					case 'url': // URL
						echo '<div>
								<h1>URL della fonte</h1>
								<p>L\'indirizzo web della fonte.</p>
								<input type="text" maxlength="128" id="url"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$fonte.', \'url\')"/>
							</div>';
						break;
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
