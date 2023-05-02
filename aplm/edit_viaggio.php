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
		$q = $conn->prepare('SELECT id FROM Viaggio WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($viaggio);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('ti', 'lp', 'dp', 'lm', 'df', 'pi', 'fo', 'pu');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_viaggio.php?id=".$viaggio);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';
	include 'php/functions_fonti.php';

	// Raccolta dati viaggio
	$q = $conn->query('SELECT * FROM Viaggio WHERE id='.$viaggio);
	$viag = $q->fetch_row();
	// Check autorizzazione alla modifica
	if ($_SESSION["nick"] != $viag[11]) {
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
		<script type="module" src="./js/edit_viaggio_init.js"></script>
		<script src="./js/edit_viaggio.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di un viaggio"/>
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
							<li><a href="./pagina_personale.php?user='.$viag[11].'">Pagina personale</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica viaggio</li>';
					} else {
						echo '<li><a href="edit_viaggio.php?id='.$viaggio.'">Modifica viaggio</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						if ($viag[2] != null) {
							$ql = $conn->query('SELECT nome FROM Luogo WHERE id='.$viag[2]);
							$luog = $ql->fetch_row();
							$nome_lp = $luog[0];
						} else {
							$nome_lp = "da inserire";
						};
						if ($viag[4] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$viag[4]);
							$inte = $qi->fetch_row();
							$int_part = $inte[0];
						} else {
							$int_part = "da inserire";
						};
						if ($viag[5] != null) {
							$ql = $conn->query('SELECT nome FROM Luogo WHERE id='.$viag[5]);
							$luog = $ql->fetch_row();
							$nome_lm = $luog[0];
						} else {
							$nome_lm = "da inserire";
						};
						if ($viag[7] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$viag[7]);
							$inte = $qi->fetch_row();
							$int_fine = $inte[0];
						} else {
							$int_fine = "da inserire";
						};
						if ($viag[9] != null) {
							$qf = $conn->query('SELECT * FROM Fonte WHERE id='.$viag[9]);
							$font = $qf->fetch_row();
							$nome_fo = get_Fonte($font);
						} else {
							$nome_fo = "da inserire";
						};
						echo	'<h1>Modifica del viaggio</h1>
								<div>
									<h2>Dati fondamentali</h2>
									<table>
										<tr><th>Titolo:</th><td><input type="text" disabled value="'.$viag[1].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'ti\')"/></td></tr>
										<tr><th>Luogo partenza:</th><td><input type="text" disabled value="'.$nome_lp.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'lp\')"/></td></tr>
										<tr><th>Data partenza:</th><td><input type="text" disabled value="'.get_Data($viag[3], $int_part, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'dp\')"/></td></tr>
										<tr><th>Luogo meta:</th><td><input type="text" disabled value="'.$nome_lm.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'lm\')"/></td></tr>
										<tr><th>Data fine:</th><td><input type="text" disabled value="'.get_Data($viag[6], $int_fine, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'df\')"/></td></tr>
										<tr><th>Fonte:</th><td><input type="text" disabled value="'.$nome_fo.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'fo\')"/></td></tr>
									</table>
								</div>';
						if ($viag[1] != null && $viag[2] != null && $viag[5] != null && $viag[9] != null && ($viag[3] != null || $viag[4] != null) && ($viag[6] != null || $viag[7] != null)) {
							
							echo '<div>
									<h2>Altri dati</h2>
									<table>
										<tr><th>Piano:</th><td><input type="text" disabled value="'.$viag[8].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'pi\')"/></td></tr>
										<tr><th>Pubblico:</th><td><input type="text" disabled value="';
							if ($viag[12] == 0) {
								echo 'Privato';
							} else {
								echo 'Pubblico';
							};
						echo '"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$viaggio.', \'pu\')"/></td></tr>
									</table>
								</div>
								<div id="map" class="map start_float"></div>
								<div class="start_float overflow">
									<h2>Tappe</h2>
									<p>Non è possibile aggiungere tappe che non siano in ultima posizione.</p>';
							$qt = $conn->query('SELECT id, posizione, luogo_partenza, data_partenza, intervallo_partenza, luogo_arrivo, data_arrivo, intervallo_arrivo, pagine FROM Tappa WHERE viaggio = '.$viaggio.' ORDER BY posizione');
							$tottapp = $qt->num_rows;
							if ($tottapp == 0) {
								echo '<p>Nessuna tappa inserita fin ora.</p>';
							} else {
								echo'<table id="tabella_tappe">
										<tr>
											<th style="color: rgba(0, 0, 0, 0);">Pos</th>
											<th>Luogo partenza</th>
											<th>Data partenza</th>
											<th>Luogo arrivo</th>
											<th>Data arrivo</th>
											<th>Pagine</th>
											<th style="color: rgba(0, 0, 0, 0);">Azioni utente</th>
										</tr>';
								for ($t = 0; $t < $tottapp; $t++) {
									$tapp = $qt->fetch_row();
									if ($tapp[2] != null) {
										$ql = $conn->query('SELECT nome FROM Luogo WHERE id = '.$tapp[2]);
										$arr_l = $ql->fetch_row();
										$tapp[2] = $arr_l[0];
									} else {
										$tapp[2] = 'da inserire';
									};
									if ($tapp[4] != null) {
										$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$tapp[4]);
										$arr_i = $qi->fetch_row();
										$tapp[4] = $arr_i[0];
									};
									if ($tapp[5] != null) {
										$ql = $conn->query('SELECT nome FROM Luogo WHERE id = '.$tapp[5]);
										$arr_l = $ql->fetch_row();
										$tapp[5] = $arr_l[0];
									} else {
										$tapp[5] = 'da inserire';
									};
									if ($tapp[7] != null) {
										$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id = '.$tapp[7]);
										$arr_i = $qi->fetch_row();
										$tapp[7] = $arr_i[0];
									};
									echo '<tr>';
									echo '<td>'.$tapp[1].'</td>';
									echo '<td>'.$tapp[2].'</td>';
									echo '<td>'.get_Data($tapp[3], $tapp[4], false).'</td>';
									echo '<td>'.$tapp[5].'</td>';
									echo '<td>'.get_Data($tapp[6], $tapp[7], false).'</td>';
									if ($tapp[8] == null) {
										echo '<td>da inserire</td>';
									} else {
										echo '<td>'.$tapp[8].'</td>';
									};
									echo '<td>
											<input class="interact" type="button" value="&#9998;" onclick="modifica_tappa('.$tapp[0].')"/>
											<input class="interact" type="button" value="X" onclick="elimina_tappa('.$tapp[0].', '.$viaggio.', '.$tapp[1].')"/>
										<td>';
									echo '<tr>';
								};
								echo '</table>';
							};
							echo '<input type="button" value="Nuova tappa" onclick="crea_tappa('.$viaggio.')">
								</div>
								<div class="special_stop"></div>
								<div class="other_float overflow">
									<h2>Partecipanti</h2>
									<p>Durante l\'aggiunta del nuovo partecipante non è possibile creare persone,<br/>ma solo selezionare fra quelle già create.</p>';
							$qp = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte, soprannome FROM Persona, partecipa_viaggio WHERE persona = Persona.id AND viaggio = '.$viaggio);
							$totpart = $qp->num_rows;
							if ($totpart == 0) {
								echo '<p>Nessun partecipante inserito fin ora.</p>';
							} else {
								echo '<ul>';
								for ($p = 0; $p < $totpart; $p++) {
									$part = $qp->fetch_row();
									echo '<li>'.$part[1].' '.$part[2].' ('.get_Data($part[3], null, true).'-'.get_Data($part[4], null, true).')';
									if ($part[5] != null) {
										echo ', detto '.$part[5];
									};
									echo '<input class="interact" type="button" value="X" onclick="elimina_partecipante('.$part[0].', '.$viaggio.')"/></li>';
								};
								echo '</ul>';
							};
							echo '<input type="button" value="Nuovo partecipante" onclick="crea_partecipante('.$viaggio.')">
									</div>
									<div class="other_float overflow">
										<h2>Motivi</h2>
										<p>Durante l\'aggiunta del nuovo motivo non è possibile creare persone e scopi,<br/>ma solo selezionare fra quelle già creati.</p>';
							$qs = $conn->query('SELECT Scopo.id, Tipo_Scopo.tipo, Scopo.successo FROM motivo_viaggio, Scopo, Tipo_Scopo WHERE viaggio = '.$viaggio.' AND Scopo.id = motivo_viaggio.scopo AND Scopo.tipo = Tipo_Scopo.id');
							$totscop = $qs->num_rows;
							if ($totscop == 0) {
								echo '<p>Nessuno scopo inserito fin ora.</p>';
							} else {
								echo '<ul>';
								for ($s = 0; $s < $totscop; $s++) {
									$scop = $qs->fetch_row();
									echo '<li>'.$scop[1].' ';
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
									echo 'riuscito)<input class="interact" type="button" value="X" onclick="elimina_motivo('.$scop[0].', '.$viaggio.')"/></li>';
								};
								echo '</ul>';
							};
							echo '<input type="button" value="Nuovo motivo" onclick="crea_motivo('.$viaggio.')">
									</div>
									<div class="stop_float"></div>';
						} else {
							echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
						};
						break;
					case 'ti': // Titolo
						echo '<div>
								<h1>Titolo del viaggio</h1>
								<p>Stringa di testo rappresentativa di tutto il viaggio, può essere una breve citazione o un titolo inventato dallo schedatore.</p>
								<input type="text" maxlength="64" id="ti"/><br/>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$viaggio.', \'ti\')"/>
							</div>';
						break;
					case 'lp': // Luogo partenza
						echo '<div>
								<h1>Luogo partenza del viaggio</h1>
								<p>Il luogo da cui è partito il viaggio, nonché il luogo di partenza della prima tappa.<br/>Si può selezionare dall\'elenco, ricercare nel database o inserirne di nuovi trovandoli su siti autorevoli o scegliendoli dalla mappa.</p>
							</div>
							<div id="pop_lp_viaggio">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_lp_viaggio" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<div><input type="radio" id="lp'.$luog[0].'" name="lp_viaggio" value="'.$luog[0].'"> <label for="lp'.$luog[0].'">'.$luog[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="lp_viaggio_search">Cerca nel database:</label>
								</br>
								<input type="text" list="lp_viaggio_list" id="lp_viaggio_search" name="lp_viaggio_search">
								<datalist id="lp_viaggio_list">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<option data-id="'.$luog[0].'" value="'.$luog[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="luogo_search(\'lp\')">
								<input type="text" id="lp_viaggio_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuovo" onclick="apri_insert(\'lp\', this)">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$viaggio.', \'lp\')"/>
							</div>';
						break;
					case 'lm': // Luogo meta
						echo '<div>
								<h1>Luogo partenza del viaggio</h1>
								<p>Il luogo da cui è partito il viaggio, nonché il luogo di partenza della prima tappa.<br/>Si può selezionare dall\'elenco, ricercare nel database o inserirne di nuovi trovandoli su siti autorevoli o scegliendoli dalla mappa.</p>
							</div>
							<div id="pop_lm_viaggio">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_lm_viaggio" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<div><input type="radio" id="lm'.$luog[0].'" name="lm_viaggio" value="'.$luog[0].'"> <label for="lm'.$luog[0].'">'.$luog[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="lm_viaggio_search">Cerca nel database:</label>
								</br>
								<input type="text" list="lm_viaggio_list" id="lm_viaggio_search" name="lm_viaggio_search">
								<datalist id="lm_viaggio_list">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<option data-id="'.$luog[0].'" value="'.$luog[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="luogo_search(\'lm\')">
								<input type="text" id="lm_viaggio_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuovo" onclick="apri_insert(\'lm\', this)">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$viaggio.', \'lm\')"/>
							</div>';
						break;
					case 'dp': // Data partenza
						echo '<div>
								<h1>Data di partenza del viaggio</h1>
								<p>Data in cui è iniziato il viaggio, coincide con la data in cui è iniziata la prima tappa.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra secoli e quarti di secoli.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'dp\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'dp\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'dp\')" <label for="anno">Solo anno</label></div>
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'dp\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$viaggio.', \'dp\')"/>
							</div>';
						break;
					case 'df': // Data fine
						echo '<div>
								<h1>Data di partenza del viaggio</h1>
								<p>Data in cui è terminato il viaggio, coincide con la data in cui è terminata l\'ultima tappa.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra secoli e quarti di secoli.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'df\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'df\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'df\')" <label for="anno">Solo anno</label></div>
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'df\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$viaggio.', \'df\')"/>
							</div>';
						break;
					case 'pi': // Piano
						echo '<div>
								<h1>Piano del viaggio</h1>
								<p>Paragrafo per descrivere più dettagliatamente gli scopi del viaggio e se questi siano cambiati in corso d’opera.</p>
								<input type="textarea" id="pi"/><br/>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$viaggio.', \'pi\')"/>
							</div>';
						break;
					case 'fo': // Fonte
						echo '<div>
								<h1>Fonte del viaggio</h1>
								<p>La fonte che certifica la provenienza delle informazioni sul viaggio<br/>Si può selezionare dall\'elenco delle proprie, ricercare nel database, inserirne una nuova da zero o copiarne una da un altro utente.<br/><br/>
								<em>Attenzione!</em><br/>Se vuoi modificare una tua fonte dovrai farlo dalla tua <a href="./pagina_personale.php?user='.$viag[11].'">pagina personale</a>.</p>
							</div>
							<div id="pop_fonte">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_fonte" class="dropdown_content">';
						$q = $conn->query('SELECT * FROM Fonte WHERE schedatore = "'.$viag[11].'"');
						$totfont = $q->num_rows;
						for ($f = 0; $f < $totfont; $f++) {
							$font = $q->fetch_row();
							echo '<div><input type="radio" id="f'.$font[0].'" name="fonte" value="'.$font[0].'"> <label for="f'.$font[0].'">'.get_Fonte($font).'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h2>Se non hai trovato quello che cerchi</h2>
								<label for="fonte_search">Cerca nel database:</label>
								</br>
								<input type="text" list="fonte_list" id="fonte_search" name="fonte_search">
								<datalist id="fonte_list">';
						$q = $conn->query('SELECT * FROM Fonte WHERE schedatore = "'.$viag[11].'"');
						$totfont = $q->num_rows;
						for ($f = 0; $f < $totfont; $f++) {
							$font = $q->fetch_row();
							echo '<option data-id="'.$font[0].'" value="'.get_Fonte($font).'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="fonti_search(\'lm\')">
								<input type="text" id="fonte_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuova" onclick="apri_insert(\'f\', this, \''.$viag[11].'\')"><input type="button" value="Copia esistente" onclick="copia_fonte(this, \''.$viag[11].'\')"><br/>
								<label for="pag_viaggio">Pagine specifiche:</label><br/>
								<input type="text" id="pag_viaggio" maxlength="32">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$viaggio.', \'fo\', this)"/>
							</div>';
						break;
					case 'pu': // Pubblico
						echo '<div>
							<h1>Visibilità del viaggio</h1>
							<p>Se il viaggio è visibile agli altri utenti.</p>
						</div>
						<div class="dropdown">
							<input type="button" value="Scegli dall&#8217;elenco">
							<div id="ddc_tipo_scopo" class="dropdown_content">
								<div><input type="radio" id="si" name="pubblico" value=1><label for="si">Pubblico</label></div>
								<div><input type="radio" id="no" name="pubblico" value=0><label for="no">Privato</label></div>
							</div>
						</div>
						<div class="blank_space"></div>
						<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$viaggio.', \'pu\')"/>';
						break;
					default:
						header("Location: index.php");
						break;
				};
			?>
		</div>
		<footer>
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
