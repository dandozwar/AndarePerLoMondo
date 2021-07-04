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

	// Ottengo l'id della persona
	if (!isset($_GET["persona"])) {
		//header("Location: index.php");
	};

	// Raccolgo i dati generali della persona
	$q = $conn->prepare('SELECT * FROM Persona WHERE id = ?');
	$q->bind_param('i', $_GET["persona"]);
	$q->execute();
	$q->store_result();
	if ($q->num_rows == 0) {
		//header("Location: index.php");
	};
	$q->bind_result($idpersona, $nome, $cognome, $soprannome, $data_nascita, $ln_id, $data_morte, $lm_id, $uri, $bio);
	$q->fetch();
	$q->free_result();
	if ($bio == NULL) {
		//header("Location: index.php");
	};
	$q->free_result();
	$dn_completa = get_Data($data_nascita, False);
	$dn_anno = get_Data($data_nascita, True);
	if ($ln_id != NULL) {
		$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$ln_id);
		$luogo = $q->fetch_row();
		$luogo_nascita = $luogo[0];
		$q->free_result();
	} else {
		$luogo_nascita = "Sconosciuto";
	};
	$dm_completa = get_Data($data_morte, False);
	$dm_anno = get_Data($data_morte, True);
	if ($lm_id != NULL) {
		$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$lm_id);
		$luogo = $q->fetch_row();
		$luogo_morte = $luogo[0];
		$q->free_result();
	} else {
		$luogo_morte = "Sconosciuto";
	};
?>
<!DOCTYPE html>
<html lang="it">
	<head>
		<meta charset="UTF-8"/>
		<link rel="icon" href="./img/LogoAPLM.png"/>
		<link rel="stylesheet" type="text/css" href="./css/general.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" />
		<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script src="./js/functions_date.js"></script>
		<script type="module" src="./js/presentazione_init.js"></script>
		<script src="./js/accedi.js"></script>
		<script src="./js/background.js"></script>
		<?php
			echo '<title>APLM - '.$nome.' '.$cognome.' (presentazione)</title>';
			echo '<meta name="author" content="Alessandro Cignoni"/>';
			echo '<meta name="description" content="Andare per lo mondo: '.$nome.' '.$cognome.' (presentazione)"/>';
		?>
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
			<?php
				if ($dn_anno == NULL) {
					echo '<h2 id="p'.$idpersona.'">'.$nome.' '.$cognome.' († '.$dm_anno.')</h2>';
				} else {
					echo '<h2 id="p'.$idpersona.'">'.$nome.' '.$cognome.' ('.$dn_anno.'-'.$dm_anno.')</h2>';
				};
				$q = $conn->query('SELECT descrizione FROM Biografia WHERE persona = '.$idpersona);
				$descrizione = $q->fetch_row();
				echo '<p>'.$descrizione[0].'</p>';
				echo '<p><a href="./biografia.php?persona='.$idpersona.'">Vai alla linea del tempo della biografia</a>.</p>';
				$q->free_result();
			?>
			<div id="map" class="map start_float"></div>
			<div class="start_float">
				<h3>Viaggi</h3>
				<?php
					echo '<p>Sulla mappa sono visibili una selezione dei viaggi di '.$nome.' '.$cognome.'.</p>';
				?>
				<ul id="viaggi">
				</ul>
			</div>
			<div class="special_stop"></div>
			<div class="other_float">
				<h3>Attività svolte</h3>
				<?php
					echo '<ul>';
					$q = $conn->query('SELECT Occupazione.attivita, lavora_come.data_inizio, lavora_come.data_fine FROM lavora_come, Occupazione WHERE lavora_come.occupazione = Occupazione.id AND lavora_come.persona = '.$idpersona);
					$totlavo = $q->num_rows;
					for ($l = 0; $l < $totlavo; $l++) {
						$lavo = $q->fetch_row();
						echo '<li>'.$lavo[0];
						if ($lavo[1] != NULL && $lavo[2] != NULL) {
							$di = get_Data($lavo[1], False);
							$df = get_Data($lavo[2], False);
							if ($di == $df) {
								echo ' (in '.$di.')';
							} else {
								echo ' (da '.$di.' a '.$df.')';
							};
						};
						echo '.</li>';
					};
					echo '<ul>';
				?>
			</div>
			<div class="other_float">
				<h3>Relazioni commericiali e politiche</h3>
				<?php
					$q = $conn->query('SELECT Tipo_Relazione.tipo, relazione.data_inizio, relazione.data_fine, Persona.nome, Persona.Cognome FROM Persona, relazione, Tipo_Relazione WHERE relazione.tipo = Tipo_Relazione.id AND relazione.persona1 = '.$idpersona.' AND relazione.persona2 = Persona.id');
					$totrela = $q->num_rows;
					if ($totrela == 0) {
						echo "Nessuna relazione relativa ai viaggi di questa persona nel database.";
					} else {
						echo '<ul>';
						for ($l = 0; $l < $totrela; $l++) {
							$rela = $q->fetch_row();
							echo '<li>'.$rela[0].' '.$rela[3].' '.$rela[4];
							if ($rela[1] != NULL && $rela[2] != NULL) {
								$di = get_Data($rela[1], False);
								$df = get_Data($rela[2], False);
								if ($di == $df) {
									echo ' (in '.$di.')';
								} else {
									echo ' (da '.$di.' a '.$df.')';
								};
							};
							echo '.</li>';
						};
						echo '<ul>';
					};
				?>
			</div>
		</div>
		<div class="stop_float">
			<p>
				<h3>Note</h3>
				<ol>
					<?php
						$q = $conn->query('SELECT DISTINCT Fonte.id, Fonte.cit_biblio FROM Fonte, Viaggio, partecipa_viaggio WHERE Viaggio.fonte = Fonte.id AND partecipa_viaggio.persona = '.$idpersona.' AND partecipa_viaggio.viaggio = Viaggio.id ORDER BY Fonte.id');
						$totfont = $q->num_rows;
						for ($f = 0; $f < $totfont; $f++) {
							$font = $q->fetch_row();
							echo '<li id="f'.$font[0].'">'.$font[1].'</li>';
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
