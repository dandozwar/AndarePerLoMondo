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
	if (isset($_GET["id"])) {
		$q = $conn->prepare('SELECT id FROM Persona WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($persona);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('no', 'co', 'so', 'ln', 'dn', 'lm', 'dm', 'uri');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_persona.php?id=".$persona);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';

	// Raccolta dati persona
	$q = $conn->query('SELECT * FROM Persona WHERE id='.$persona);
	$pers = $q->fetch_row();
	// Check autorizzazione alla modifica
	if ($_SESSION["nick"] != $pers[11]) {
		header("Location: index.php");
	};
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
		<script type="module" src="./js/edit_persona_init.js"></script>
		<script src="./js/edit_persona.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di una persona"/>
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
							<li><a href="./pagina_personale.php?user='.$pers[11].'">Pagina personale</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica persona</li>';
					} else {
						echo '<li><a href="edit_persona.php?id='.$persona.'">Modifica persona</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						if ($pers[5] != null) {
							$ql = $conn->query('SELECT nome FROM Luogo WHERE id='.$pers[5]);
							$luog = $ql->fetch_row();
							$nome_ln = $luog[0];
						} else {
							$nome_ln = "da inserire";
						};
						if ($pers[9] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$pers[9]);
							$inte = $qi->fetch_row();
							$int_nasc = $inte[0];
						} else {
							$int_nasc = "da inserire";
						};
						if ($pers[7] != null) {
							$ql = $conn->query('SELECT nome FROM Luogo WHERE id='.$pers[7]);
							$luog = $ql->fetch_row();
							$nome_lm = $luog[0];
						} else {
							$nome_lm = "da inserire";
						};
						if ($pers[10] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$pers[10]);
							$inte = $qi->fetch_row();
							$int_mort = $inte[0];
						} else {
							$int_mort = "da inserire";
						};
						echo '<h1>Modifica della persona</h1>
							<div>
								<h2>Dati fondamentali</h2>
								<table>
									<tr><th>Nome:</th><td><input type="text" disabled value="'.$pers[1].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'no\')"/></td></tr>
									<tr><th>Cognome / Patronimico / Altro:</th><td><input type="text" disabled value="'.$pers[2].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'co\')"/></td></tr>
								</table>
							</div>';
						if ($pers[1] != null && $pers[2] != null) {
							echo '<div>
									<h2>Altri dati</h2>
									<table>
										<tr><th>Soprannome:</th><td><input type="text" disabled value="'.$pers[3].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'so\')"/></td></tr>
										<tr><th>Luogo nascita:</th><td><input type="text" disabled value="'.$nome_ln.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'ln\')"/></td></tr>
										<tr><th>Data nascita / Prima attestazione:</th><td><input type="text" disabled value="'.get_Data($pers[4], $int_nasc, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'dn\')"/></td></tr>
										<tr><th>Luogo morte:</th><td><input type="text" disabled value="'.$nome_lm.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'lm\')"/></td></tr>
										<tr><th>Data morte / Ultima attestazione:</th><td><input type="text" disabled value="'.get_Data($pers[6], $int_mort, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'dm\')"/></td></tr>
									<tr><th>URI:</th><td><input type="text" disabled value="'.$pers[8].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$persona.', \'uri\')"/></td></tr>
									</table>';
							$qb = $conn->query('SELECT id, pubblico FROM Biografia WHERE persona = '.$persona);
							$bioFlag = $qb->num_rows;
							if ($bioFlag != 0) {
								$biog = $qb->fetch_row();
								if ($biog[1] == 1) {
									echo '<a href="biografia.php?persona='.$persona.'">Visualizza biografia</a><br/>';
								};
								echo '<input type="button" value="Modifica biografia" onclick="modifica_bio('.$persona.')"><input type="button" value="Elimina biografia" onclick="elimina_bio('.$persona.')">';
							} else {
								echo '<input type="button" value="Crea biografia" onclick="crea_bio('.$persona.')">';
							};
							echo '</div>
								<div class="other_float overflow">
										<h2>Attività svolte</h2>';
							$qo = $conn->query('SELECT * FROM lavora_come WHERE persona = '.$persona.' ORDER BY COALESCE(data_inizio, data_fine)');
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
									echo '<input class="interact" type="button" value="&#9998;" onclick="modifica_occu('.$occu[0].')"/>
								<input class="interact" type="button" value="X" onclick="elimina_occu('.$occu[0].')"/></li>';
								};
								echo '</ul>';
							} else {
								echo '<p>Nessuna attività aggiunta fin ora.</p>';
							};
							echo '<input type="button" value="Nuova attività" onclick="crea_occu('.$persona.')">
									</div>
									<div class="other_float overflow">
										<h2>Relazioni</h2>';
							$qr = $conn->query('SELECT * FROM relazione WHERE persona1 = '.$persona.' ORDER BY COALESCE(data_inizio, data_fine)');
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
										}
									} else {
										echo 'da completare';
									};
									echo '<input class="interact" type="button" value="&#9998;" onclick="modifica_rela('.$rela[0].')"/>
								<input class="interact" type="button" value="X" onclick="elimina_rela('.$rela[0].')"/></li>';
								};
								echo '</ul>';
							} else {
								echo '<p>Nessuna relazione aggiunta fin ora.</p>';
							};
							echo '<input type="button" value="Nuova relazione" onclick="crea_rela('.$persona.')">
									</div>
									<div class="stop_float"></div>';
						} else {
							echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
						};
						break;
					case 'no': // Nome
						echo '<div>
								<h1>Nome</h1>
								<p>Il nome di battesimo della persona.</p>
								<input type="text" maxlength="32" id="no"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'no\')"/>
							</div>';
						break;
					case 'co': // Cognome
						echo '<div>
								<h1>Cognome, patronimico o altro</h1>
								<p>Il cognome, il nome di famiglia, il patronimico o il riferimento al casato o al luogo caratteristico che identificavano la persona.</p>
								<input type="text" maxlength="32" id="co"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'co\')"/>
							</div>';
						break;
					case 'so': // Soprannome
						echo '<div>
								<h1>Soprannome</h1>
								<p>Il nome alternativo con cui era chiamata la persona.</p>
								<input type="text" maxlength="32" id="so"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'so\')"/>
							</div>';
						break;
					case 'ln': // Luogo nascita
						echo '<div>
								<h1>Luogo nascita</h1>
								<p>Il luogo in cui è nata la persona.<br/>Si può selezionare dall\'elenco, ricercare nel database o inserirne di nuovi trovandoli su siti autorevoli o scegliendoli dalla mappa.</p>
							</div>
							<div id="pop_ln_pers">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_ln_pers" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<div><input type="radio" id="ln'.$luog[0].'" name="ln_pers" value="'.$luog[0].'"> <label for="ln'.$luog[0].'">'.$luog[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="ln_pers_search">Cerca nel database:</label>
								</br>
								<input type="text" list="ln_pers_list" id="ln_pers_search" name="ln_pers_search">
								<datalist id="ln_pers_list">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<option data-id="'.$luog[0].'" value="'.$luog[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="luogo_search(\'ln\')">
								<input type="text" id="ln_pers_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuovo" onclick="apri_insert(\'ln\', this)">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$persona.', \'ln\')"/>
							</div>';
						break;
					case 'lm': // Luogo morte
						echo '<div>
								<h1>Luogo morte</h1>
								<p>Il luogo in cui è morta la persona.<br/>Si può selezionare dall\'elenco, ricercare nel database o inserirne di nuovi trovandoli su siti autorevoli o scegliendoli dalla mappa.</p>
							</div>
							<div id="pop_lm_pers">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_lm_pers" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<div><input type="radio" id="lm'.$luog[0].'" name="lm_pers" value="'.$luog[0].'"> <label for="lm'.$luog[0].'">'.$luog[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="lm_pers_search">Cerca nel database:</label>
								</br>
								<input type="text" list="lm_pers_list" id="lm_pers_search" name="lm_pers_search">
								<datalist id="lm_pers_list">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<option data-id="'.$luog[0].'" value="'.$luog[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="luogo_search(\'lm\')">
								<input type="text" id="lm_pers_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuovo" onclick="apri_insert(\'lm\', this)">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$persona.', \'lm\')"/>
							</div>';
						break;
					case 'dn': // Data nascita
						echo '<div>
								<h1>Data nascita o prima attestazione</h1>
								<p>Data in cui la persona è nata o, in alternativa, la data conosciuta più indietro nel tempo che la riguarda.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra metà di secoli e quarti di secoli.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'dn\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'dn\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'dn\')" <label for="anno">Solo anno</label></div>
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'dn\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'dn\')"/>
							</div>';
						break;
					case 'dm': // Data morte
						echo '<div>
								<h1>Data morte o ultima attestazione</h1>
								<p>Data in cui la persona è mortao, in alternativa, la data conosciuta più recente che la riguarda.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra metà di secoli e quarti di secoli.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'dm\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'dm\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'dm\')" <label for="anno">Solo anno</label></div>
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'dm\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'dm\')"/>
							</div>';
						break;
					case 'uri': // URI
						echo '<div>
								<h1>URI della persona</h1>
								<p>Il link a un sito autorevole che certifichi le informazioni sulla persona inserite.<br/>In ordine utilizzare il <a href="https://www.treccani.it/enciclopedia/elenco-opere/Dizionario_Biografico" target="_blank">Dizionario Biografico degli italiani</a>, l’<a href="https://www.treccani.it/enciclopedia/" target="_blank">Enciclopedia Treccani</a> o <a href="https://www.wikidata.org/wiki/Wikidata:Main_Page" target="_blank">Wikidata</a></p>
								<input type="text" maxlength="256" id="uri"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$persona.', \'uri\')"/>
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
