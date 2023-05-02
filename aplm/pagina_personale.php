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
	if (isset($_GET["user"])) {
		$user = $_GET["user"];
		$q = $conn->prepare('SELECT nick FROM Utente WHERE nick = ?');
		$q->bind_param("s", $user);
		$q->execute();
		$q->store_result();
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
		if (isset($_SESSION["nick"])) {
			if ($_SESSION["nick"] != $user) {
				$modifiche = False;
			} else {
				$modifiche = True;
			};
		} else {
			$modifiche = False;
		};
	} else {
		header("Location: index.php");
	};

	//Include le funzioni
	include 'php/functions_date.php';
	include 'php/functions_fonti.php';
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
		<script type="module" src="./js/pagina_personale_init.js"></script>
		<script src="./js/pagina_personale.js"></script>
		<script src="./js/accedi.js"></script>
		<script src="./js/background.js"></script>
		<?php
			echo '<title>'.$user.' - Andare per lo mondo </title>
					<meta name="description" content="Andare per lo mondo: utente '.$user.'"/>';
			if ($modifiche) {
				echo '<meta id="abilitato" value="1">';
			};
		?>
		<meta name="author" content="Alessandro Cignoni"/>
	</head>
	<body>
		<header>
			<h1>Andare per lo mondo</h1>
			<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Andare per lo mondo"/></a>
			<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" id="logo2" class="stemmi" title="Laboratorio Cultura Digitale"/></a>
			<ul id = "breadcrumb" class="breadcrumb">
				<li><a href='./index.php'>Home</a></li>
				<li>Pagina personale</li>
				<?php
					if (isset($_SESSION["nick"])) {
						echo '<input class="login" type="button" id="esci" value="Esci" onclick="esci()"/>';
					} else {
						echo '<input class="login" type="button" id="accedi" value="Accedi o registrati" onclick="accedi_registrati()"/>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				echo '<h1>'.$user.'</h1>';
			?>
			<h2>Dati personali</h2>
			<table>
			<?php
				$q = $conn->query('SELECT nome, cognome, ente, ruolo FROM Utente WHERE nick = "'.$user.'"');
				$uten = $q->fetch_row();
				echo '<tr><th>Nickname:</th><td>'.$user.'</td></tr>
					<tr><th>Nome:</th><td>'.$uten[0].'</td></tr>
					<tr><th>Cognome:</th><td>'.$uten[1].'</td></tr>
					<tr><th>Ente:</th><td>'.$uten[2].'</td></tr>
					<tr><th>Ruolo:</th><td>'.$uten[3].'</td></tr>';
			?>
			</table>
			<?
			if ($modifiche) {
			echo'<p>Se non sai come procedere vai al <a href="./manuale.php">Manuale Utente</a>.</p>';
			};
			?>
		</div>
		<div class="other_float overflow">
			<h3>Persone</h3>
			<?php
				$q = $conn->query('SELECT id, nome, cognome, data_nascita, data_morte, soprannome, intervallo_nascita, intervallo_morte FROM Persona WHERE schedatore = "'.$user.'" ORDER BY nome');
				$totpers = $q->num_rows;
				if ($totpers == 0) {
					echo '<p>Nessuna persona inserita fin ora.</p>';
				} else {
					echo '<ul>';
					for ($p = 0; $p < $totpers; $p++) {
						$pers = $q->fetch_row();
							if ($pers[6] != null) {
								$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$pers[6]);
								$inte = $qi->fetch_row();
								$int_nasc = $inte[0];
							} else {
								$int_nasc = "?";
							};
							if ($pers[7] != null) {
								$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$pers[7]);
								$inte = $qi->fetch_row();
								$int_mort = $inte[0];
							} else {
								$int_mort = "?";
							};
						echo '<li>';
						if ($pers[1] == null && $pers[2] == null) {
							echo 'Anonimo';
						} else {
							echo $pers[1].' '.$pers[2];
						};
						echo ' ('.get_Data($pers[3], $int_nasc, true).'-'.get_Data($pers[4], $int_mort, true).')';
						if ($pers[5] != null) {
							echo ', detto '.$pers[5];
						};
						if ($modifiche) {
							echo '<input class="interact" type="button" value="&#9998;" onclick="modifica_persona('.$pers[0].')"/>
									<input class="interact" type="button" value="X" onclick="elimina_persona('.$pers[0].')"/>';
						};
						echo '</li>';
					};
					echo '</ul>';
				};
				if ($modifiche) {
					echo '<input type="button" value="Nuova persona" onclick="crea_persona()">';
				};
			?>
		</div>
		<div class="other_float overflow">
			<h3>Scopi</h3>
			<p>Durante la creazione dello scopo non è possibile creare persone,<br/>ma solo selezionare fra quelle già create.</p>
			<?php
				$qs = $conn->query('SELECT Scopo.id, tipo, successo FROM Scopo WHERE  schedatore = "'.$user.'"');
				$totscop = $qs->num_rows;
				if ($totscop == 0) {
					echo '<p>Nessuna scopo inserito fin ora.</p>';
				} else {
					echo '<ul>';
					for ($s = 0; $s < $totscop; $s++) {
						$scop = $qs->fetch_row();
						if ($scop[1] != null) {
							$qts = $conn->query('SELECT * FROM Tipo_Scopo WHERE id = '.$scop[1]);
							$tisc = $qts->fetch_row();
							$tipo_sc = $tisc[1];
						} else {
							$tipo_sc = 'da inserire';
						};
						echo '<li>'.$tipo_sc.' ';
						$qd = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte, intervallo_nascita, intervallo_morte FROM Persona, destinatario WHERE scopo = '.$scop[0].' AND persona = Persona.id');
						$totdest = $qd->num_rows;
						if ($totdest != 0) {							
							echo ' ';
							for ($d = 0; $d < $totdest; $d++) {
								$dest = $qd->fetch_row();
								if ($dest[5] != null) {
									$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$dest[5]);
									$inte = $qi->fetch_row();
									$int_nasc = $inte[0];
								} else {
									$int_nasc = "?";
								};
								if ($dest[6] != null) {
									$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$dest[6]);
									$inte = $qi->fetch_row();
									$int_mort = $inte[0];
								} else {
									$int_mort = "?";
								};
								echo $dest[1].' '.$dest[2].' ('.get_Data($dest[3], $int_nasc, true).'-'.get_Data($dest[4], $int_mort, true).'), ';
							};
						};
						$qm = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte, intervallo_nascita, intervallo_morte FROM Persona, mandante WHERE scopo = '.$scop[0].' AND persona = Persona.id');
						$totmand = $qm->num_rows;
						if ($totmand != 0) {
							echo 'per conto di ';
							for ($m = 0; $m < $totmand; $m++) {
								$mand = $qm->fetch_row();
								if ($mand[5] != null) {
									$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$mand[5]);
									$inte = $qi->fetch_row();
									$int_nasc = $inte[0];
								} else {
									$int_nasc = "?";
								};
								if ($mand[6] != null) {
									$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$mand[6]);
									$inte = $qi->fetch_row();
									$int_mort = $inte[0];
								} else {
									$int_mort = "?";
								};
								echo $mand[1].' '.$mand[2].' ('.get_Data($mand[3], $int_nasc, true).'-'.get_Data($mand[4], $int_mort, true).'), ';
							};
						};
						echo '(';
						if ($scop[2] == null) {
							echo 'da inserire';
						} else {
							if ($scop[2] == 0) {
								echo 'non ';
							};
							echo 'riuscito';
						};
						echo ')';
						if ($modifiche) {
							echo '<input class="interact" type="button" value="&#9998;" onclick="modifica_scopo('.$scop[0].')"/>
								<input class="interact" type="button" value="X" onclick="elimina_scopo('.$scop[0].')"/>';
						};
						echo '</li>';
					};
					echo '</ul>';
				};
				if ($modifiche) {
					echo '<input type="button" value="Nuovo scopo" onclick="crea_scopo()">';
				};
			?>
		</div>
		<div class="stop_float">
		<div id="map" class="map start_float"></div>
		<div class="start_float overflow">
			<h3>Viaggi</h3>
			<p>Durante la creazione del viaggio non è possibile creare persone e scopi,<br/>ma solo selezionare fra quelle già create.</p>
			<ul id="viaggi">
			</ul>
			<?php
				if ($modifiche) {
					echo '<input type="button" value="Nuovo viaggio" onclick="crea_viaggio()"/>';
				};
			?>
		</div>
		<div class="special_stop"></div>
		</div>
		<div class="overflow">
			<h3>Fonti</h3>
			<p>Le fonti si creano (da zero o copiandole da quelle di altri utenti) durante la creazione dei viaggi.</p>
			<?php
				$q = $conn->query('SELECT Fonte.id, autore, Fonte.titolo, titolo_volume, titolo_rivista, numero, nome_sito, curatore, luogo, editore, anno, collana, Fonte.pagine, url FROM Fonte WHERE schedatore = "'.$user.'" ORDER BY Fonte.id');
				$totfont = $q->num_rows;
				if ($totfont == 0) {
					echo '<p>Nessuna fonte inserita fin ora.</p>';
				} else {
					echo '<ul>';
					for ($f = 0; $f < $totfont; $f++) {
						$font = $q->fetch_row();
						echo '<li id="f'.$font[0].'">['.$font[0].'] '.get_Fonte($font);
						if ($modifiche) {
							echo '<input class="interact" type="button" value="&#9998;" onclick="modifica_fonte('.$font[0].')"/><input class="interact" type="button" value="X" onclick="elimina_fonte('.$font[0].')"/>';
						};
						echo '</li>';
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
