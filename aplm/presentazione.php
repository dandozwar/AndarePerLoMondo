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

	// Include le funzioni
	include 'php/functions_date.php';
	include 'php/functions_fonti.php';

	// Ottiene l'id della persona
	if (!isset($_GET["persona"])) {
		header("Location: index.php");
	};

	// Raccoglie i dati generali della persona
	$q = $conn->prepare('SELECT Persona.id, nome, cognome, soprannome, data_nascita, intervallo_nascita, luogo_nascita, data_morte, intervallo_morte, luogo_morte, uri, schedatore, pubblico FROM Persona, Biografia WHERE Persona.id = ? AND Persona.id = persona');
	$q->bind_param('i', $_GET["persona"]);
	$q->execute();
	$q->store_result();
	if ($q->num_rows == 0) {
		header("Location: index.php");
	};
	$q->bind_result($idpersona, $nome, $cognome, $soprannome, $data_nascita, $intervallo_nascita, $ln_id, $data_morte, $intervallo_morte, $lm_id, $uri, $schedatore, $pubblico);
	$q->fetch();
	$q->free_result();
	if ($intervallo_nascita != NULL) {
		$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$intervallo_nascita);
		$inter = $q->fetch_row();
		$intervallo_nascita = $inter[0];
		$q->free_result();
	};
	$dn_completa = get_Data($data_nascita, $intervallo_nascita, False);
	$dn_anno = get_Data($data_nascita, $intervallo_nascita, True);
	if ($ln_id != NULL) {
		$q = $conn->query('SELECT nome FROM Luogo WHERE id = '.$ln_id);
		$luogo = $q->fetch_row();
		$luogo_nascita = $luogo[0];
		$q->free_result();
	} else {
		$luogo_nascita = "Sconosciuto";
	};
	if ($intervallo_morte != NULL) {
		$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$intervallo_morte);
		$inter = $q->fetch_row();
		$intervallo_morte = $inter[0];
		$q->free_result();
	};
	$dm_completa = get_Data($data_morte, $intervallo_morte, False);
	$dm_anno = get_Data($data_morte, $intervallo_morte, True);
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
				<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Andare per lo mondo"/></a>
				<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" id="logo2" class="stemmi" title="Laboratorio Cultura Digitale"/></a>
			<ul id = "breadcrumb" class="breadcrumb">
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
					if ($dn_anno == NULL) {
						echo '<h2 id="p'.$idpersona.'">'.$nome.' '.$cognome.' († '.$dm_anno.')</h2>';
					} else {
						echo '<h2 id="p'.$idpersona.'">'.$nome.' '.$cognome.' ('.$dn_anno.'-'.$dm_anno.')</h2>';
					};
					$q = $conn->query('SELECT descrizione FROM Biografia WHERE persona = '.$idpersona);
					$descrizione = $q->fetch_row();
					echo '<p>'.$descrizione[0].'</p>';
					echo '<p><a href="./biografia.php?persona='.$idpersona.'">Vai alla linea del tempo della biografia</a>.</p>';
					echo '<p>Dati inseriti da <a href="pagina_personale.php?user='.$schedatore.'">'.$schedatore.'</a></p>';
					$q->free_result();
					echo '<div id="map" class="map start_float"></div>
						<div class="start_float overflow">
							<h3>Viaggi</h3>
							<p>Sulla mappa sono visibili una selezione dei viaggi di '.$nome.' '.$cognome.'.</p>
							<ul id="viaggi">
							</ul>
						</div>
					<div class="special_stop"></div>
					<div class="other_float overflow">
						<h3>Attività svolte</h3>
						<ul>';
					$qo = $conn->query('SELECT * FROM lavora_come WHERE persona = '.$idpersona.' ORDER BY COALESCE(data_inizio, data_fine)');
					$totoccu = $qo->num_rows;
					if ($totoccu != 0) {
						echo '<ul>';
						for ($o = 0; $o < $totoccu; $o++) {
							$occu = $qo->fetch_row();
							echo '<li>';
							if ($occu[2] != null) {
								$qao = $conn->query('SELECT attivita FROM Occupazione WHERE id = '.$occu[2]);
								$atoc = $qao->fetch_row();
								echo $atoc[0];
								if ($occu[3] != null || $occu[4] != null || $occu[5] != null || $occu[6] != null) {
									if ($occu[5] != null) {
										$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$occu[5]);
										$inte = $qi->fetch_row();
										$int_iniz = $inte[0];
									} else {
										$int_iniz = "da inserire";
									};
									if ($occu[6] != null) {
										$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$occu[6]);
										$inte = $qi->fetch_row();
										$int_fine = $inte[0];
									} else {
										$int_fine = "da inserire";
									};
									$di = get_Data($occu[3], $int_iniz, False);
									$df = get_Data($occu[4], $int_fine, False);
									if ($di == $df) {
										echo ' ('.$di.')';
									} else {
										echo ' ('.$di.'-'.$df.')';
									};
								}
							} else {
								echo 'da completare';
							};
							echo '</li>';
						};
						echo '</ul>';
					} else {
						echo '<p>Nessuna attività aggiunta fin ora.</p>';
					};
					echo '</div>
					<div class="other_float overflow">
						<h3>Relazioni commericiali e politiche</h3>';
					$qr = $conn->query('SELECT * FROM relazione WHERE persona1 = '.$idpersona.' ORDER BY COALESCE(data_inizio, data_fine)');
					$totrela = $qr->num_rows;
					if ($totrela != 0) {
						echo '<ul>';
						for ($r = 0; $r < $totrela; $r++) {
							$rela = $qr->fetch_row();
							echo '<li>';
							if ($rela[2] != null && $rela[3] != null) {
								$qpr = $conn->query('SELECT nome, cognome FROM Persona WHERE id = '.$rela[2]);
								$pere = $qpr->fetch_row();
								$qtr = $conn->query('SELECT tipo FROM Tipo_Relazione WHERE id = '.$rela[3]);
								$tire = $qtr->fetch_row();
								echo $tire[0].' '.$pere[0].' '.$pere[1];
								if ($rela[4] != null || $rela[5] != null | $rela[6] != null || $rela[7] != null) {
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
									$di = get_Data($rela[4], $int_iniz, False);
									$df = get_Data($rela[5], $int_fine, False);
									if ($di == $df) {
										echo ' ('.$di.')';
									} else {
										echo ' ('.$di.'-'.$df.')';
									};
								};
							} else {
								echo 'da completare';
							};
							echo '</li>';
						};
						echo '</ul>';
					} else {
						echo '<p>Nessuna relazione aggiunta fin ora.</p>';
					};
					echo' </div>
					</div>
					<div class="stop_float">
						<h3>Note</h3>
						<ul>';
					$q = $conn->query('SELECT DISTINCT Fonte.id, autore, Fonte.titolo, titolo_volume, titolo_rivista, numero, curatore, luogo, editore, nome_sito, anno, collana, Fonte.pagine, url, Fonte.schedatore FROM Fonte, Viaggio, partecipa_viaggio WHERE fonte = Fonte.id AND persona = '.$idpersona.' AND viaggio = Viaggio.id ORDER BY Fonte.id');
					$totfont = $q->num_rows;
					for ($f = 0; $f < $totfont; $f++) {
						$font = $q->fetch_row();
						echo '<li id="f'.$font[0].'">['.$font[0].'] '.get_Fonte($font).'</li>';
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
