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

	// Includo le funzioni
	include 'php/functions_date.php';
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
			<img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Logo di Andare per lo mondo"/>
			<img src="./img/LogoUniPi.png" id="logo2" class="stemmi" title="Logo dell'Università di Pisa"/>
			<ul id = "breadcrumb" class="breadcrumb">
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
			<h2>Seleziona viaggi</h2>
			<button onclick="check_all(true)">Seleziona tutti</button>
			<button onclick="check_all(false)">Deseleziona tutti</button>
			<?php
				$q = $conn->query('SELECT DISTINCT Persona.id, Persona.nome, Persona.cognome FROM partecipa_viaggio, Persona, Biografia WHERE Persona.id = partecipa_viaggio.persona AND Persona.id = Biografia.persona');
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
				for ($l = 0; $l < $totpers; $l++) {
					echo '<tr>';
					echo '<td><a href="./presentazione.php?persona='.$persone[$l][0].'">'.$persone[$l][1].' '.$persone[$l][2].'</a></td>';
					$q = $conn->query('SELECT Viaggio.id, Viaggio.titolo, Viaggio.data_partenza, Viaggio.data_fine, Viaggio.fonte, Viaggio.pagine FROM Viaggio, partecipa_viaggio WHERE Viaggio.id = partecipa_viaggio.viaggio AND partecipa_viaggio.persona ='.$persone[$l][0].' ORDER BY Viaggio.data_partenza, Viaggio.id');
					$totviag = $q->num_rows;
					echo '<td><ul style="list-style-type:none;">';
					for ($v = 0; $v < $totviag; $v++) {
						$viag = $q->fetch_row();
						$dp_anno = get_Data($viag[2], True);
						$df_anno = get_Data($viag[3], True);
						echo '<li><input type="checkbox" id="v'.$viag[0].'_'.$v.'" name="v'.$viag[0].'_'.$v.'" value="'.$viag[0].'" onclick="tick_on(this)">';
						echo '<label for="v'.$viag[0].'">';
						if ($dp_anno == $df_anno) {
							echo $viag[1].' ('.$dp_anno.')';
						} else {
							echo $viag[1].' ('.$dp_anno.'-'.$df_anno.')';
						};
						echo ' [<a href="#'.$viag[4].'">'.$viag[4].'</a> '.$viag[5].'].';
						echo '</label>';
						$q2 = $conn->query('SELECT Persona.nome, Persona.cognome FROM Persona, partecipa_viaggio WHERE partecipa_viaggio.viaggio = '.$viag[0].' AND Persona.id = partecipa_viaggio.persona AND Persona.id <> '.$persone[$l][0]);
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
					$q->free_result();
				};
				echo '</table>';
				echo '</form>';
			?>
			<button onclick="show_Viaggi()">Visualizza viaggi</button>
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
				<ol>
					<?php
						$q = $conn->query('SELECT DISTINCT Fonte.id, Fonte.cit_biblio FROM Fonte, Viaggio WHERE Viaggio.fonte = Fonte.id ORDER BY Fonte.id');
						$totfont = $q->num_rows;
						for ($f = 0; $f < $totfont; $f++) {
							$font = $q->fetch_row();
							echo '<li id="'.$font[0].'">'.$font[1].'</li>';
						};
					?>
				</ol>
			</p>
		<div>
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
