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

	// Ottiene l'id della persona
	if (!isset($_GET["persona"])) {
		header("Location: index.php");
	};

	// Raccoglie i dati generali della persona
	$q = $conn->prepare('SELECT nome, cognome, Biografia.id, schedatore ,pubblico FROM Persona, Biografia WHERE persona = Persona.id AND Persona.id = ?');
	$q->bind_param("i", $_GET["persona"]);
	$q->execute();
	$q->store_result();
	if ($q->num_rows == 0) {
		header("Location: index.php");
	};
	$q->bind_result($nome, $cognome, $bio, $schedatore, $pubblico);
	$q->fetch();
	$q->free_result();

	if ($nome == NULL) {
		header("Location: index.php");
	};
?>
<html lang="it">
	<head>
		<meta charset="UTF-8"/>
		<link rel="icon" href="./img/LogoAPLM.png"/>
		<link rel="stylesheet" type="text/css" href="./css/general.css" />
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<link title="timeline-styles" rel="stylesheet" href="./css/timeline_css.css">
		<script src="https://cdn.knightlab.com/libs/timeline3/latest/js/timeline.js"></script>
		<script type="module" src="./js/biografia_init.js"></script>
		<script src="./js/accedi.js"></script>
		<script src="./js/commenta.js"></script>
		<script src="./js/background.js"></script>
		<?php
			echo '<title>APLM - '.$nome.' '.$cognome.' (biografia)</title>';
			echo '<meta name="author" content="Alessandro Cignoni"/>';
			echo '<meta name="description" content="Andare per lo mondo: '.$nome.' '.$cognome.' (biografia)"/>';
		?>
	</head>
	<body>
		<header>
			<?php
				echo '<h1 id="b'.$_GET["persona"].'">Andare per lo mondo</h1>';
			?>
				<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Andare per lo mondo"/></a>
				<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" id="logo2" class="stemmi" title="Laboratorio Cultura Digitale"/></a>
			<ul id="breadcrumb" class="breadcrumb">
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
			<?php
				if ($pubblico == 0) {
					echo '<h2>Non hai accesso alla pagina.</h2>';
				} else {
					echo '<div id="timeline-embed" style="width: 100%; height: 600px"></div>
						<div>
							<p>Dati inseriti da <a href="pagina_personale.php?user='.$schedatore.'">'.$schedatore.'</a>.</p>
							<h3>Commenti</h3>
							<input id="commenta" type="button" onclick="commenta()" value="Commenta"/>
							<div id="comment_panel" hidden="hidden">
								<div class="close" onclick="stop_commento()">X</div>';
					if (isset($_SESSION["nick"])) {
						echo '
							<form id="comment_form">
								<label for="testo">Testo del commento:</label><br/>
								<textarea id="testo" name="testo" rows="4" cols="50" form="comment_form"></textarea><br/><br/>
								<input id="'.$_SESSION["nick"].'"type="button" onclick="conferma_commento(this, 0)" value="Invia"></input>
							</form>';
					} else {
						echo 'Per commentare devi aver effettuato l’accesso.';
					};
					echo '</div><div>';
					$q = $conn->query('SELECT nome, cognome, ruolo, ente, commento FROM Commento_Biografia, Utente WHERE autore = Utente.nick AND biografia = '.$bio);
					$totcomm = $q->num_rows;
					if ($totcomm == 0) {
						echo '<p>Questa biografia non ha commenti.</p>';
					} else {
						echo '<ul>';
						for ($c = 0; $c < $totcomm; $c++) {
							$comm = $q->fetch_row();
							echo '<li>
									<span class="commento_titolo">'.$comm[0].' '.$comm[1].', '.$comm[2].' di '.$comm[3].'</span><br/>'.$comm[4].'							
								</li>';
						};
						echo '</ul>';
					};
					echo '</div>';
				};
			?>
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
