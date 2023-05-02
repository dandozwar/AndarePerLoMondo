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

	// Include le funzioni
	include 'php/functions_Viaggio.php';
	include 'php/functions_date.php';
	include 'php/functions_fonti.php';

	// Ottiene l'id del viaggio
	if (!isset($_GET["viaggio"])) {
		header("Location: index.php");
	};
	
	// Raccoglie i dati generali del viaggio
	$q = $conn->prepare('SELECT * FROM Viaggio WHERE id = ?');
	$q->bind_param("i", $_GET["viaggio"]);
	$q->execute();
	$q->store_result();
	if ($q->num_rows == 0) {
		header("Location: index.php");
	};
	$q->bind_result($idviaggio, $titolo, $lp_id, $data_partenza, $intervallo_partenza, $lm_id, $data_fine, $intervallo_fine, $piano, $fonte, $pagine, $schedatore, $pubblico);
	$q->fetch();
	$q->free_result();
	$q = $conn->query('SELECT nome, latitudine, longitudine, uri FROM Luogo WHERE id = '.$lp_id);
	$luogo = $q->fetch_row();
	$q->free_result();
	$luogo_partenza = $luogo[0];
	$lp_lat = $luogo[1];
	$lp_lon = $luogo[2];
	$lp_uri = $luogo[3];
	if ($intervallo_partenza != NULL) {
		$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$intervallo_partenza);
		$inter = $q->fetch_row();
		$intervallo_partenza = $inter[0];
		$q->free_result();
	};
	$dp_completa = get_Data($data_partenza, $intervallo_partenza, False);
	$dp_anno = get_Data($data_partenza, $intervallo_partenza, True);
	$q = $conn->query('SELECT nome, latitudine, longitudine, uri FROM Luogo WHERE id = '.$lm_id);
	$luogo = $q->fetch_row();
	$q->free_result();
	$luogo_meta = $luogo[0];
	$lm_lat = $luogo[1];
	$lm_lon = $luogo[2];
	$lm_uri = $luogo[3];
	if ($intervallo_fine != NULL) {
		$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$intervallo_fine);
		$inter = $q->fetch_row();
		$intervallo_fine = $inter[0];
		$q->free_result();
	};
	$df_completa = get_Data($data_fine, $intervallo_fine, False);
	$df_anno = get_Data($data_fine, $intervallo_fine, True);
?>
<html lang="it">
	<head>
		<meta charset="UTF-8"/>
		<link rel="icon" href="./img/LogoAPLM.png"/>
		<link rel="stylesheet" type="text/css" href="./css/general.css" />
		<link rel="stylesheet" type="text/css" href="./css/popover.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/css/ol.css" />
		<script src="https://cdn.jsdelivr.net/gh/openlayers/openlayers.github.io@master/en/v6.5.0/build/ol.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
		<script type="module" src="./js/viaggio_init.js"></script>
		<script src="./js/popover.js"></script>
		<script src="./js/accedi.js"></script>
		<script src="./js/commenta.js"></script>
		<script src="./js/background.js"></script>
		<?php
			echo '<title>APLM - '.$titolo.'</title>
				  <meta name="author" content="Alessandro Cignoni"/>
				  <meta name="description" content="Andare per lo mondo: '.$titolo.'"/>';
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
					echo '<h2>'.$titolo.' (';
					if ($dp_anno == $df_anno) {
						echo $dp_anno;
					}  else {
						echo $dp_anno.'-'.$df_anno;
					};
					echo ')</h2>';
					echo '<div hidden="hidden">
							<span id="idviaggio">'.$idviaggio.'</span>
						</div>';
					echo '<div id="map" class="map start_float"></div>';
					echo '<div class="start_float"><h3>Descrizione</h3>';
					// Dati viaggio
					echo 'Il viaggio «'.$titolo.'», iniziato da ';
					echo '<span id="'.$lp_id.'over" class="popover_localita" onclick="pop_hover(this)">'.$luogo_partenza.'</span>';
					echo '<div id="pop_'.$lp_id.'over" class="popover_content">
							<div class="popover_close" onclick="pop_out(this)">X</div>
							<h3>Località: '.$luogo_partenza.'</h3>
							<p>Coordinate: <span id="lat'.$lp_id.'">'.$lp_lat.'</span> e <span id="lon'.$lp_id.'">'.$lp_lon.'<span></p>';
					if ($lp_uri != NULL) {
						echo '<p><a href="'.$lp_uri.'" target="_blank">Vedi più dettagli su siti esterni</a>.<p>';
					};
					echo	'<div id="map'.$lp_id.'" class="map"></div>
						  </div>';
					echo ' per arrivare a ';
					echo '<span href="#" id="'.$lm_id.'over" class="popover_localita" onclick="pop_hover(this)">'.$luogo_meta.'</span>';
					echo '<div id="pop_'.$lm_id.'over" class="popover_content">
							<div class="popover_close" onclick="pop_out(this)">X</div>
							<h3>Località: '.$luogo_meta.'</h3>
							<p>Coordinate: <span id="lat'.$lm_id.'">'.$lm_lat.'</span> e <span id="lon'.$lm_id.'">'.$lm_lon.'<span></p>';
					if ($lm_uri != NULL) {
						echo '<p><a href="'.$lm_uri.'" target="_blank">Vedi più dettagli su siti esterni</a>.<p>';
					};
					echo	'<div id="map'.$lm_id.'" class="map"></div>
						  </div>';
					if ($data_partenza != NULL) {
						if ($data_partenza == $data_fine) {
							echo ' del '.$dp_completa;
						} else {
							echo ' compiuto fra '.$dp_completa.' e '.$df_completa;
						};
					};
					echo ',  ';
					// Scopi viaggio
					echo get_Scopo("Viaggio", $idviaggio, $conn);
					echo '. ';
					// Piano
					if ($piano != NULL) {
						echo $piano.'<br/>';
					};
					// Partecipanti viaggio
					echo ' Partecipanti: ';
					$q = $conn->query('SELECT nome, cognome, id, uri FROM partecipa_viaggio, Persona WHERE viaggio ='.$idviaggio.' AND persona = id');
					$part = $q->num_rows;
					if ($part == 1) {
						$persona = $q->fetch_row();
					 	echo'<span id="p'.$persona[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$persona[0].' '.$persona[1].'</span>';
						echo '<div id="pop_p'.$persona[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
								<h3>'.$persona[0].' '.$persona[1].' '.get_Vita($persona[2], $conn).'</h3>
								<p>'.get_Bio($persona[2], $conn).'</p>';
						$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$persona[2].' AND pubblico = 1');
						if ($qBio->num_rows != 0) {
							echo '<p><a href="./presentazione.php?persona='.$persona[2].'" target="_self">Vai alla presentazione</a>.<p>';
						};
						$qBio->free_result();
						if ($persona[3] != NULL) {
							echo '<p><a href="'.$persona[3].'" target="_blank">Vai a una biografia esterna</a>.<p>';
						};
						echo '</div>';
					} else {
						for ($p = 0; $p < $part; $p++) {
							$persona = $q->fetch_row();
							if ($p == $part-1) {
								echo ' e <span id="p'.$persona[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$persona[0].' '.$persona[1].'</span>';
								echo '<div id="pop_p'.$persona[2].'over" class="popover_content">
										<div class="popover_close" onclick="pop_out(this)">X</div>
										<h3>'.$persona[0].' '.$persona[1].'</h3>
										<p>'.get_Bio($persona[2], $conn).'</p>';
								$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$persona[2]);
								if ($qBio->num_rows != 0) {
									echo '<p><a href="./presentazione.php?persona='.$persona[2].'" target="_self">Vai alla presentazione</a>.<p>';
								};
								if ($persona[3] != NULL) {
									echo '<p><a href="'.$persona[3].'" target="_blank">Vai a una biografia esterna</a>.<p>';
								};
								echo '</div>';
							} else {
								echo ' <span id="p'.$persona[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$persona[0].' '.$persona[1].'</span>,';
								echo '<div id="pop_p'.$persona[2].'over" class="popover_content">
										<div class="popover_close" onclick="pop_out(this)">X</div>
										<h3>'.$persona[0].' '.$persona[1].'</h3>
										<p>'.get_Bio($persona[2], $conn).'</p>';
								$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$persona[2]);
								if ($qBio->num_rows != 0) {
									echo '<p><a href="./presentazione.php?persona='.$persona[2].'" target="_self">Vai alla presentazione</a>.<p>';
								};
								if ($persona[3] != NULL) {
									echo '<p><a href="'.$persona[3].'" target="_blank">Vai a una biografia esterna</a>.<p>';
								};
								echo '</div>';
							};
						};
					};

					// Nota
					echo ' [<a href="#'.$fonte.'">'.$fonte.'</a>';
					if ($pagine != NULL) {
						echo ' '.$pagine;
					};
					echo '].';
					echo '<p>Dati inseriti da <a href="pagina_personale.php?user='.$schedatore.'">'.$schedatore.'</a>.</p>';
					echo '</div>';
				?>
				<div class="stop_float overflow">
					<h3>Tappe</h3>
					<ul style="position: relative; list-style-type: none;">
					<?php
						$q = $conn->query('SELECT * FROM Tappa WHERE viaggio = '.$idviaggio.' ORDER BY POSIZIONE');
						$tottapp = $q->num_rows;
						$lasttext = "";
						$text = "";
						for ($t = 0; $t < $tottapp; $t++) {
							$tappa = $q->fetch_row();
							echo '<li>'.$tappa[8].'. ';
							$q2 = $conn->query('SELECT nome, latitudine, longitudine, uri FROM Luogo WHERE id = '.$tappa[2]);
							$luogo = $q2->fetch_row();
							$lp_lat = $luogo[1];
							$lp_lon = $luogo[2];
							$lp_uri = $luogo[3];
							$q2->free_result();
							$luogo_partenza = $luogo[0];
							$q2 = $conn->query('SELECT nome, latitudine, longitudine, uri FROM Luogo WHERE id = '.$tappa[4]);
							$luogo = $q2->fetch_row();
							$q2->free_result();
							$luogo_arrivo = $luogo[0];
							$la_lat = $luogo[1];
							$la_lon = $luogo[2];
							$la_uri = $luogo[3];
							echo 'Da <span id="'.$tappa[2].'over" class="popover_localita" onclick="pop_hover(this)">'.$luogo_partenza.'</span>';
							echo '<div id="pop_'.$tappa[2].'over" class="popover_content">
									<div class="popover_close" onclick="pop_out(this)">X</div>
									<h3>Località: '.$luogo_partenza.'</h3>
									<p>Coordinate: <span id="lat'.$tappa[2].'">'.$lp_lat.'</span> e <span id="lon'.$tappa[2].'">'.$lp_lon.'<span></p>';
					if ($lp_uri != NULL) {
						echo '<p><a href="'.$lp_uri.'" target="_blank">Vedi più dettagli su siti esterni</a>.<p>';
					};
					echo	'<div id="map'.$tappa[2].'" class="map"></div>
								  </div>';
							if ($tappa[3] != NULL) {
								if ($tappa[9] != NULL ) {
									$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$tappa[9]);
									$inter = $q->fetch_row();
									$tappa[9] = $inter[0];
									$q->free_result();
								};
								echo ' ('.get_Data($tappa[3], $tappa[9], False).')';
							};
							echo ' a <span id="'.$tappa[4].'over" class="popover_localita" onclick="pop_hover(this)">'.$luogo_arrivo.'</span>';
							echo '<div id="pop_'.$tappa[4].'over" class="popover_content">
									<div class="popover_close" onclick="pop_out(this)">X</div>
									<h3>Località: '.$luogo_arrivo.'</h3>
									<p>Coordinate: <span id="lat'.$tappa[4].'">'.$la_lat.'</span> e <span id="lon'.$tappa[4].'">'.$la_lon.'</span></p>';
					if ($la_uri != NULL) {
						echo '<p><a href="'.$la_uri.'" target="_blank">Vedi più dettagli su siti esterni</a>.<p>';
					};
					echo	'<div id="map'.$tappa[4].'" class="map"></div>
								  </div>';
							if ($tappa[5] != NULL) {
								if ($tappa[10] != NULL)  {
									$q = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$tappa[10]);
									$inter = $q->fetch_row();
									$tappa[10] = $inter[0];
									$q->free_result();
								};
								echo ' ('.get_Data($tappa[5], $tappa[10], False).')';
							};
							//Scopi tappa
							$text = $text.get_Scopo("Tappa", $tappa[0], $conn);
							$text = $text.'. ';
							// Partecipanti tappa
							$q3 = $conn->query('SELECT nome, cognome, id, uri FROM partecipa_tappa, Persona WHERE tappa ='.$tappa[0].' AND persona = id');
							$part = $q3->num_rows;
							if ($part != 0) {
								$text = $text.'Altri partecipanti: ';
								if ($part == 1) {
									$persona = $q3->fetch_row();
									$text = $text.'<span id="p'.$persona[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$persona[0].' '.$persona[1].'</span>';
									$text = $text.'<div id="pop_p'.$persona[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
										<h3>'.$persona[0].' '.$persona[1].' '.get_Vita($persona[2], $conn).'</h3>
										<p>'.get_Bio($persona[2], $conn).'</p>';
									$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$persona[2]);
									if ($qBio->num_rows != 0) {
										$text = $text.'<p><a href="./presentazione.php?persona='.$persona[2].'" target="_self">Vai alla presentazione</a>.<p>';
									};
									$qBio->free_result();
									if ($persona[3] != NULL) {
										$text = $text.'<p><a href="'.$persona[3].'" target="_blank">Vai a una biografia esterna</a>.<p>';
									};
									$text = $text.'</div>';
								} else {
									for ($p = 0; $p < $part; $p++) {
										$persona = $q3->fetch_row();
										if ($p == $part-1) {
											$text = $text.' e <span id="p'.$persona[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$persona[0].' '.$persona[1].'</span>';
											$text = $text.'<div id="pop_p'.$persona[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
										<h3>'.$persona[0].' '.$persona[1].'</h3>
										<p>'.get_Bio($persona[2], $conn).'</p>';
											$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$persona[2]);
											if ($qBio->num_rows != 0) {
												$text = $text.'<p><a href="./presentazione.php?persona='.$persona[2].'" target="_self">Vai alla presentazione</a>.<p>';
											};
											$qBio->free_result();
											if ($persona[3] != NULL) {
												$text = $text.'<p><a href="'.$persona[3].'" target="_blank">Vai a una biografia esterna</a>.<p>';
											};
											$text = $text.'</div>';
										} else {
											$text = $text.' <span id="p'.$persona[2].'over" class="popover_persona" onclick="pop_hover(this)">'.$persona[0].' '.$persona[1].'</span>,';
											$text = $text.'<div id="pop_p'.$persona[2].'over" class="popover_content">
								<div class="popover_close" onclick="pop_out(this)">X</div>
										<h3>'.$persona[0].' '.$persona[1].'</h3>
										<p>'.get_Bio($persona[2], $conn).'</p>';
											$qBio = $conn->query('SELECT id FROM Biografia WHERE persona ='.$persona[2]);
											if ($qBio->num_rows != 0) {
												$text = $text.'<p><a href="./presentazione.php?persona='.$persona[2].'" target="_self">Vai alla presentazione</a>.<p>';
											};
											$qBio->free_result();
											if ($persona[3] != NULL) {
												$text = $text.'<p><a href="'.$persona[3].'" target="_blank">Vai a una biografia esterna</a>.<p>';
											};
											$text = $text.'</div>';
										};
									};
								};
								$text = $text.'. ';
							};
							$q3->free_result();
							//Merci tappa
							$q4 = $conn->query('SELECT tipo, quantita, valore FROM trasporta, Merce WHERE merce = id AND tappa ='.$tappa[0]);
							$merci = $q4->num_rows;
							if ($merci != 0) {
								$text = $text.'Merci trasportate: ';
								if ($merci == 1) {
									$merce = $q4->fetch_row();
									$text = $text.$merce[0];
									if ($merce[1] != NULL || $merce[2] != NULL) {
										$text = $text.' (';
										if ($merce[1] != NULL) {
											$text = $text.$merce[1];
										};								
										if ($merce[2] != NULL) {
											$text = $text.$merce[2];
										};
										$text = $text.')';
									};
								} else {
									$merce = $q4->fetch_row();
									for ($m = 0; $m < $merci; $m++) {
										if ($m == $merci-1) {
											$text = $text.' e '.$merce[0];
											if ($merce[1] != NULL || $merce[2] != NULL) {
												$text = $text.' (';
												if ($merce[1] != NULL) {
													$text = $text.$merce[1];
												};								
												if ($merce[2] != NULL) {
													$text = $text.$merce[2];
												};
												echo ')';
											};
										} else {
											echo $merce[0].', ';
											if ($merce[1] != NULL || $merce[2] != NULL) {
												$text = $text.' (';
												if ($merce[1] != NULL) {
													$text = $text.$merce[1];
												};								
												if ($merce[2] != NULL) {
													$text = $text.$merce[2];
												};
												$text = $text.')';
											};
										};
									};
								};
							};
							$q4->free_result();
							//Nota tappa
							if ($tappa[7] != NULL) {
								$text = $text.' ['.$tappa[7].'].';
							};
							if($text == $lasttext) {
								echo '. Vedi precedente.';
							} else {
								echo $text;
							};
							echo'</li>';
							$lasttext = $text;
							$text = "";
						};
					?>
					</ul>
				</div>
			</div>
			<div>
				<h3>Note</h3>
				<ul>
				<?php
					$q = $conn->query('SELECT DISTINCT Fonte.id, autore, Fonte.titolo, titolo_volume, titolo_rivista, numero, curatore, luogo, editore, nome_sito, anno, collana, Fonte.pagine, url, Fonte.schedatore FROM Fonte, Viaggio WHERE fonte = Fonte.id  AND Viaggio.id = '.$idviaggio);
					$font = $q->fetch_row();
					echo '<li id="'.$font[0].'">['.$font[0].'] '.get_Fonte($font).'</li>';
				?>
				</ul>
			</div>
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
									<input id="'.$_SESSION["nick"].'"type="button" onclick="conferma_commento(this, 1)" value="Invia"></input>
								</form>';
						} else {
							echo 'Per commentare devi aver effettuato l’accesso.';
						}; 
					?>
				</div>
				<?php
					$q = $conn->query('SELECT nome, cognome, ruolo, ente, commento FROM Commento_Viaggio, Utente WHERE autore = Utente.nick AND viaggio = '.$idviaggio);
					$totcomm = $q->num_rows;
					if ($totcomm == 0) {
						echo '<p>Questo viaggio non ha commenti.</p>';
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
