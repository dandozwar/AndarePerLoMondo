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
	if (isset($_GET["id"]) && isset($_GET["tipo"])) {
		if ($_GET["tipo"] == 'v') {
			$q = $conn->prepare('SELECT id FROM Viaggio WHERE id = ?');
			$q->bind_param("s", $_GET["id"]);
			$q->execute();
			$q->store_result();
			$q->bind_result($viaggio);
			$q->fetch();
			if ($q->num_rows() == 0) {
				header("Location: index.php");
			} else {
				$flagTipo = 'v';
				// Dati viaggio
				$q = $conn->query('SELECT * FROM Viaggio WHERE id='.$viaggio);
				$viag = $q->fetch_row();
				// Check autorizzazione alla modifica
				if ($_SESSION["nick"] != $viag[11]) {
					header("Location: index.php");
				};
			};
		} else if ($_GET["tipo"] == 't') {
			$q = $conn->prepare('SELECT id FROM Tappa WHERE id = ?');
			$q->bind_param("s", $_GET["id"]);
			$q->execute();
			$q->store_result();
			$q->bind_result($tappa);
			$q->fetch();
			if ($q->num_rows() == 0) {
				header("Location: index.php");
			} else {
				$flagTipo = 't';
				// Dati tappa
				$q = $conn->query('SELECT * FROM Tappa WHERE id='.$tappa);
				$tapp = $q->fetch_row();
				// Dati viaggio
				$q2 = $conn->query('SELECT * FROM Viaggio WHERE id='.$tapp[1]);
				$viag = $q2->fetch_row();
				// Check autorizzazione alla modifica
				if ($_SESSION["nick"] != $viag[11]) {
					header("Location: index.php");
				};
			};
		} else {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};

	//Include le funzioni
	include 'php/functions_date.php';
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
		<script src="./js/insert_motivo.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: aggiungi motivo"/>
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
						<li><a href="./pagina_personale.php?user='.$viag[11].'">Pagina personale</a></li>
						<li><a href="./edit_viaggio.php?id='.$viag[0].'">Modifica viaggio</a></li>';
					if ($flagTipo == 't') {
						echo '<li><a href="edit_tappa.php?id='.$tappa.'">Modifica Tappa</a></li>';
					};
					echo '<li>Aggiungi motivo</li>';
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagTipo) {
					case 'v':
						echo '<div>
								<h1>Aggiungi motivo al viaggio</h1>
								<p>Scegli uno scopo dall&#8217;elenco o cercalo nel database.</p>
								<h3>Attenzione!</h3>
								<p>Se vuoi inserire una nuova persona dovrai farlo dalla tua <a href="./pagina_personale.php?user='.$viag[11].'">pagina personale</a>.</p>
								<table>
									<tr><th>Viaggio:</th><td>'.$viag[1].'</td></tr>
								</table>
						</div>
						<div id="scop_viaggio">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_scop_viaggio" class="dropdown_content">';
						$qs = $conn->query('SELECT Scopo.id, Tipo_Scopo.tipo, successo FROM Scopo, Tipo_Scopo WHERE Scopo.tipo = Tipo_Scopo.id');
						$totscop = $qs->num_rows;
						for ($s = 0; $s < $totscop; $s++) {
							$scop = $qs->fetch_row();
							echo '<div><input type="radio" id="scop'.$scop[0].'" name="scop_viaggio" value="'.$scop[0].'"> <label for="scop'.$scop[0].'">'.$scop[1].' ';
							$qd = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, destinatario WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totdest = $qd->num_rows;
							if ($totdest != 0) {
								echo ' ';
								for ($d = 0; $d < $totdest; $d++) {
									$dest = $qd->fetch_row();
									echo $dest[1].' '.$dest[2].' ('.get_Data($dest[3], null, true).'-'.get_Data($dest[4], null, true).')';
								};
								echo ', ';
							};
							$qm = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, mandante WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totmand = $qm->num_rows;
							if ($totmand != 0) {
								echo 'per conto di ';
								for ($m = 0; $m < $totmand; $m++) {
									$mand = $qm->fetch_row();
									echo $mand[1].' '.$mand[2].' ('.get_Data($mand[3], null, true).'-'.get_Data($mand[4], null, true).')';
								};
								echo ', ';
							};
							echo '(';
							if ($scop[2] == 0) {
								echo 'non ';
							};
							echo 'riuscito)</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="sco
p_viaggio_search">Cerca nel database:</label>
								</br>
								<input type="text" list="scop_viaggio_list" id="scop_viaggio_search" name="scop_viaggio_search">
								<datalist id="scop_viaggio_list">';
						$qs = $conn->query('SELECT Scopo.id, Tipo_Scopo.tipo, successo FROM Scopo, Tipo_Scopo WHERE Scopo.tipo = Tipo_Scopo.id');
						$totscop = $qs->num_rows;
						for ($s = 0; $s < $totscop; $s++) {
							$scop = $qs->fetch_row();
							echo  '<option data-id="'.$scop[0].'" value="'.$scop[1].' ';
							$qd = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, destinatario WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totdest = $qd->num_rows;
							if ($totdest != 0) {
								echo ' ';
								for ($d = 0; $d < $totdest; $d++) {
									$dest = $qd->fetch_row();
									echo $dest[1].' '.$dest[2].' ('.get_Data($dest[3], null, true).'-'.get_Data($dest[4], null, true).')';
								};
								echo ', ';
							};
							$qm = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, mandante WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totmand = $qm->num_rows;
							if ($totmand != 0) {
								echo 'per conto di ';
								for ($m = 0; $m < $totmand; $m++) {
									$mand = $qm->fetch_row();
									echo $mand[1].' '.$mand[2].' ('.get_Data($mand[3], null, true).'-'.get_Data($mand[4], null, true).')';
								};
								echo ', ';
							};
							echo '(';
							if ($scop[2] == 0) {
								echo 'non ';
							};
							echo 'riuscito)">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="scop_search(\'v\')">
								<input type="text" id="scop_viaggio_selected" hidden="hidden">
							<br/><br/><input type="button" value="Invia" id="invia"  onclick="invia_motivo(\'v\', '.$viag[0].')"/>
							</div>';
						break;
					case 't':
						echo '<div>
								<h1>Aggiungi motivo alla tappa</h1>
								<p>Scegli un motivo dall&#8217;elenco o cercalo nel database.<br/>Non deve già partecipare al viaggio.<br/><br/>
								<em>Attenzione!</em><br/>Se vuoi inserire una nuova persona dovrai farlo dalla tua <a href="./pagina_personale.php?user="'.$viag[11].'">pagina personale</a>.</p>
								<table>
									<tr><th>Viaggio:</th><td>'.$viag[1].'</td></tr>
									<tr><th>Tappa in posizione:</th><td>'.$tapp[8].'</td></tr>
								</table>
						</div>
						<div id="scop_tappa">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_scop_tappa" class="dropdown_content">';
						$qs = $conn->query('SELECT Scopo.id, Tipo_Scopo.tipo, successo FROM Scopo, Tipo_Scopo WHERE Scopo.tipo = Tipo_Scopo.id AND Scopo.tipo IS NOT NULL');
						$totscop = $qs->num_rows;
						for ($s = 0; $s < $totscop; $s++) {
							$scop = $qs->fetch_row();
							echo '<div><input type="radio" id="scop'.$scop[0].'" name="scop_tappa" value="'.$scop[0].'"> <label for="scop'.$scop[0].'">'.$scop[1].' ';
							$qd = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, destinatario WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totdest = $qd->num_rows;
							if ($totdest != 0) {
								echo ' ';
								for ($d = 0; $d < $totdest; $d++) {
									$dest = $qd->fetch_row();
									echo $dest[1].' '.$dest[2].' ('.get_Data($dest[3], null, true).'-'.get_Data($dest[4], null, true).')';
								};
								echo ', ';
							};
							$qm = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, mandante WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totmand = $qm->num_rows;
							if ($totmand != 0) {
								echo 'per conto di ';
								for ($m = 0; $m < $totmand; $m++) {
									$mand = $qm->fetch_row();
									echo $mand[1].' '.$mand[2].' ('.get_Data($mand[3], null, true).'-'.get_Data($mand[4], null, true).')';
								};
								echo ', ';
							};
							echo '(';
							if ($scop[2] == 0) {
								echo 'non ';
							};
							echo 'riuscito)</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="sco
p_viaggio_search">Cerca nel database:</label>
								</br>
								<input type="text" list="scop_tappa_list" id="scop_tappa_search" name="scop_tappa_search">
								<datalist id="scop_tappa_list">';
						$qs = $conn->query('SELECT Scopo.id, Tipo_Scopo.tipo, successo FROM Scopo, Tipo_Scopo WHERE Scopo.tipo = Tipo_Scopo.id AND Scopo.tipo IS NOT NULL');
						$totscop = $qs->num_rows;
						for ($s = 0; $s < $totscop; $s++) {
							$scop = $qs->fetch_row();
							echo  '<option data-id="'.$scop[0].'" value="'.$scop[1].' ';
							$qd = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, destinatario WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totdest = $qd->num_rows;
							if ($totdest != 0) {
								echo ' ';
								for ($d = 0; $d < $totdest; $d++) {
									$dest = $qd->fetch_row();
									echo $dest[1].' '.$dest[2].' ('.get_Data($dest[3], null, true).'-'.get_Data($dest[4], null, true).')';
								};
								echo ', ';
							};
							$qm = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte FROM Persona, mandante WHERE scopo = '.$scop[0].' AND persona = Persona.id');
							$totmand = $qm->num_rows;
							if ($totmand != 0) {
								echo 'per conto di ';
								for ($m = 0; $m < $totmand; $m++) {
									$mand = $qm->fetch_row();
									echo $mand[1].' '.$mand[2].' ('.get_Data($mand[3], null, true).'-'.get_Data($mand[4], null, true).')';
								};
								echo ', ';
							};
							echo '(';
							if ($scop[2] == 0) {
								echo 'non ';
							};
							echo 'riuscito)">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="scop_search(\'t\')">
								<input type="text" id="scop_tappa_selected" hidden="hidden">
							<br/><br/><input type="button" value="Invia" id="invia"  onclick="invia_motivo(\'t\', '.$tapp[0].')"/>
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
