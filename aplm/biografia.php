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
	// Ottengo l'id della persona
	if (!isset($_GET["persona"])) {
		header("Location: index.php");
	};

	// Raccolgo i dati generali della persona
	$q = $conn->prepare('SELECT nome, cognome, Biografia.id FROM Persona, Biografia WHERE persona = Persona.id AND Persona.id = ?');
	$q->bind_param("i", $_GET["persona"]);
	$q->execute();
	$q->store_result();
	if ($q->num_rows == 0) {
		header("Location: index.php");
	};
	$q->bind_result($nome, $cognome, $bio);
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
			<img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Logo di Andare per lo mondo"/>
			<img src="./img/LogoUniPi.png" id="logo2" class="stemmi" title="Logo dell'Università di Pisa"/>
			<ul id="breadcrumb" class="breadcrumb">
				<?php
					if (isset($_SESSION["nick"])) {
						echo '<input class="access_buttons" type="button" id="esci" value="Esci" onclick="esci()"/>';
					} else {
						echo '<input class="access_buttons" type="button" id="accedi" value="Accedi o registrati" onclick="accedi_registrati()"/>';
					};
				?>
			</ul>
		</header>
		<div id='timeline-embed' style="width: 100%; height: 600px"></div>
		<div>
			<h3>Commenti</h3>
			<input id="commenta" type="button" onclick="commenta()" value="Commenta"/>
			<div id="comment_panel" hidden="hidden">
				<div class="close" onclick="stop_commento()">X</div>
				<?php
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
				?>
			</div>
			<?php
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
			?>
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
