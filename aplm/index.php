<!DOCTYPE html>
<?php
	session_start();
	// Stabilisco una connessione con il database
	$conn = new mysqli("localhost", "visitatore", "password", "aplm");
	if (!$conn) {
		die('Connsessione fallita: '.mysql_error());
	};
	// Controllo se l'utente non è già online
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
		<script src="./js/esplora.js"></script>
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
				<img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Logo di Andare per lo mondo"/>
				<img src="./img/LogoUniPi.png" id="logo2" class="stemmi" title="Logo dell'Università di Pisa"/>
			<ul id = "breadcrumb" class="breadcrumb">
				<li>Home</li>
				<?php
					if (isset($_SESSION["nick"])) {
						echo '<input class="access_buttons" type="button" id="esci" value="Esci" onclick="esci()"/>';
					} else {
						echo '<input class="access_buttons" type="button" id="accedi" value="Accedi o registrati" onclick="accedi_registrati()"/>';
					};
				?>
			</ul>
		</header>
		<div>
			<h2>Percorsi e biografie medievali</h2>
			<p>Andare per lo mondo (APLM) è un sito per narrare, visualizzare e mettere a confronto viaggi medievali. L’obiettivo è di mostrare quanto fosse mobile la società medievale e quanto viaggiassero le persone di qualsiasi classe sociale: nobili, apparteneti al clero e sopratutto mercanti.</p>
			<h3>Perché iscriversi?</h3>
			<p>Andare per lo mondo come sito punta alla creazione di conoscenza tramite il crowdsourcing, iscrivendosi è possibile lasciare commenti sotto le biografie e i viaggi.</p>
		</div>
		<div>
			<div id="map" class="map start_float"></div>
			<div class="start_float">
				<h2>Biografie</h2>
				<p>Sulla mappa sono visibili massimo due viaggi per biografia.</p>
				<ul>
					<?php
						$q = $conn->query('SELECT * FROM Biografia');
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
						<label for="pass">Passoword:</label><br/>
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
						<label for="pass">Passoword:</label><br/>
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
					<a href="mailto@alessandro.cignoni@progettohmr.it">Alessandro Cignoni</a> - © 2021<br/>
					Tesi di laurea di Informatica Umanistica<br/>
					Relatori: professori Laura Galoppini e Vittore Casarosa<br/>
					Ringraziamenti: dottor Massimiliano Grava<br/>
				</p>
			</div>
		</footer>
	</body>
</html>
