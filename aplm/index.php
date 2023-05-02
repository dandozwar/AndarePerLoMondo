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
		<script type="module" src="./js/index_init.js"></script>
		<script src="./js/accedi.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="author" content="Alessandro Cignoni"/>
		<meta name="description" content="Andare per lo mondo: percorsi e biografie medievali"/>
	</head>
	<body>
		<header>
				<h1>Andare per lo mondo</h1>
				<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Andare per lo mondo"/></a>
				<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" id="logo2" class="stemmi" title="Laboratorio Cultura Digitale"/></a>
			<ul id = "breadcrumb" class="breadcrumb">
				<li>Home</li>
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
			<h2>Percorsi e biografie medievali</h2>
			<p>Andare per lo mondo (APLM) è un sito per narrare, visualizzare e mettere a confronto viaggi medievali. L’obiettivo è di mostrare quanto fosse mobile la società medievale e quanto viaggiassero le persone di qualsiasi classe sociale: nobili, apparteneti al clero e sopratutto mercanti.</p>
			<h3>Perché iscriversi?</h3>
			<p>Andare per lo mondo come sito punta alla creazione di conoscenza tramite il crowdsourcing, iscrivendosi è possibile lasciare commenti sotto le biografie e i viaggi degli altri e anche inserirne di nuovi.</p>
		</div>
		<div>
			<div id="map" class="map start_float"></div>
			<div class="start_float overflow">
				<h2>Biografie</h2>
				<p>Sulla mappa sono visibili massimo due viaggi per biografia.</p>
				<ul>
					<?php
						// Ordina per data di nascita, se non c'è per data di morte
						$q = $conn->query('SELECT Biografia.id, persona, presentazione, descrizione, viaggio1, viaggio2 FROM Biografia, Persona WHERE persona = Persona.id AND pubblico = 1 ORDER BY COALESCE(Persona.data_nascita, Persona.data_morte)');
						$totbiog = $q->num_rows;
						for ($b = 0; $b < $totbiog; $b++) {
							$biog = $q->fetch_row();
							echo '<li><span id="b'.$biog[0].'">'.$biog[2].'<br/></span><a href="./presentazione.php?persona='.$biog[1].'">Vedi di più...</a></li>';
						};
						$q->free_result();
					?>
				</ul>
			</div>
		</div>
		<div class="stop_float">
			<h2>Modalità esplora</h2>
			<p>La modalità esplora permette di selezionare quali viaggi del database di Andare per lo mondo visualizzare sulla mappa. <br/> Si tratta di un approccio Historical GIS ovvero di creazione di metafonti: sta all’utente trarre conclusioni o notare correlazioni fra le informazioni scelte.</p>
			<p><a href="esplora.php">Vai alla modalità esplora</a>.</p>
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
