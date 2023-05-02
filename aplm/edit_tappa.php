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
		$q = $conn->prepare('SELECT id FROM Tappa WHERE id = ?');
		$q->bind_param("s", $_GET["id"]);
		$q->execute();
		$q->store_result();
		$q->bind_result($tappa);
		$q->fetch();
		if ($q->num_rows() == 0) {
			header("Location: index.php");
		};
	} else {
		header("Location: index.php");
	};
	if (isset($_GET["campo"])) {
		$campi_ok = array('lp', 'dp', 'la', 'da', 'pag');
		if (in_array($_GET["campo"], $campi_ok)) {
			$flagCampo = $_GET["campo"];
		} else {
			header("Location: edit_tappa.php?id=".$tappa);
		};
	} else {
		$flagCampo = "base";
	};

	//Include le funzioni
	include 'php/functions_date.php';
	include 'php/functions_fonti.php';

	// Raccolta dati tappa
	$q = $conn->query('SELECT * FROM Tappa WHERE id='.$tappa);
	$tapp = $q->fetch_row();
	// Raccolta dati viaggio
	$q = $conn->query('SELECT id, titolo, schedatore FROM Viaggio WHERE id='.$tapp[1]);
	$viag = $q->fetch_row();
	// Check autorizzazione alla modifica
	if ($_SESSION["nick"] != $viag[2]) {
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
		<script type="module" src="./js/edit_tappa_init.js"></script>
		<script src="./js/edit_tappa.js"></script>
		<script src="./js/background.js"></script>
		<title>Andare per lo Mondo</title>
		<meta name="description" content="Andare per lo mondo: modifica di una tappa"/>
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
							<li><a href="./pagina_personale.php?user='.$viag[2].'">Pagina personale</a></li>
							<li><a href="./edit_viaggio.php?id='.$viag[0].'">Modifica viaggio</a></li>';
					if ($flagCampo == 'base') {
						echo '<li>Modifica tappa</li>';
					} else {
						echo '<li><a href="edit_tappa.php?id='.$tappa.'">Modifica tappa</a></li>';
					};
				?>
			</ul>
		</header>
		<div>
			<?php
				switch ($flagCampo) {
					case 'base':
						if ($tapp[2] != null) {
							$ql = $conn->query('SELECT nome FROM Luogo WHERE id='.$tapp[2]);
							$luog = $ql->fetch_row();
							$nome_lp = $luog[0];
						} else {
							$nome_lp = "da inserire";
						};
						if ($tapp[9] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$tapp[9]);
							$inte = $qi->fetch_row();
							$int_part = $inte[0];
						} else {
							$int_part = "da inserire";
						};
						if ($tapp[4] != null) {
							$ql = $conn->query('SELECT nome FROM Luogo WHERE id='.$tapp[4]);
							$luog = $ql->fetch_row();
							$nome_la = $luog[0];
						} else {
							$nome_la = "da inserire";
						};
						if ($tapp[10] != null) {
							$qi = $conn->query('SELECT stringa FROM Intervallo WHERE id='.$tapp[10]);
							$inte = $qi->fetch_row();
							$int_arri = $inte[0];
						} else {
							$int_arri = "da inserire";
						};
						echo '<h1>Modifica della tappa</h1>
							<div>
								<h2>Dati fondamentali</h2>
								<table>
									<tr><th>Posizione:</th><td>'.$tapp[8].'</td><td></td></tr>
									<tr><th>Viaggio:</th><td>'.$viag[1].'</td><td></td></tr>
									<tr><th>Luogo partenza:</th><td><input type="text" disabled value="'.$nome_lp.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$tappa.', \'lp\')"/></td></tr>
									<tr><th>Luogo arrivo:</th><td><input type="text" disabled value="'.$nome_la.'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$tappa.', \'la\')"/></td></tr>
								</table>
							</div>';
						if ($tapp[2] != null && $tapp[4] != null) {
							echo' <div>
									<h2>Altri dati</h2>
									<table>
										<tr><th>Data partenza:</th><td><input type="text" disabled value="'.get_Data($tapp[3], $int_part, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$tappa.', \'dp\')"/></td></tr>
										<tr><th>Data arrivo:</th><td><input type="text" disabled value="'.get_Data($tapp[5], $int_arri, false).'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$tappa.', \'da\')"/></td></tr>
										<tr><th>Pagine:</th><td><input type="text" disabled value="'.$tapp[7].'"/></td><td><input class="interact" type="button" value="&#9998;" onclick="modifica_campo('.$tappa.', \'pag\')"/></td></tr>
									</table>
								</div>
								<div class="other_float overflow">
									<div>
										<h2>Partecipanti</h2>
										<p>Durante l\'aggiunta del nuovo partecipante non è possibile creare persone,<br/>ma solo selezionare fra quelle già create.</p>
										<h3>Di tutto il viaggio</h3>';
							$qp = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte, soprannome FROM Persona, partecipa_viaggio WHERE persona = Persona.id AND viaggio = '.$viag[0]);
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
									echo '</li>';
								};
								echo '</ul>';
							};
							echo '</div>';
							echo '<div>
									<h3>Della singola tappa</h3>';
							$qp = $conn->query('SELECT Persona.id, nome, cognome, data_nascita, data_morte, soprannome FROM Persona, partecipa_tappa WHERE persona = Persona.id AND tappa = '.$tappa);
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
									echo '<input class="interact" type="button" value="X" onclick="elimina_partecipante('.$part[0].', '.$tappa.')"/></li>';
								};
								echo '</ul>';
							};
							echo '<input type="button" value="Nuovo partecipante" onclick="crea_partecipante('.$tappa.')">
										</div>
									</div>
									<div class="other_float overflow">
										<h2>Motivi</h2>
										<p>Durante l\'aggiunta del nuovo motivo non è possibile creare persone e scopi,<br/>ma solo selezionare fra quelle già creati.</p>';
							$qs = $conn->query('SELECT Scopo.id, Tipo_Scopo.tipo, Scopo.successo FROM motivo_tappa, Scopo, Tipo_Scopo WHERE tappa = '.$tappa.' AND Scopo.id = motivo_tappa.scopo AND Scopo.tipo = Tipo_Scopo.id');
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
									echo 'riuscito)<input class="interact" type="button" value="X" onclick="elimina_motivo('.$scop[0].', '.$tappa.')"/></li>';
								};
								echo '</ul>';
							};
							echo '<input type="button" value="Nuovo scopo" onclick="crea_motivo('.$tappa.')">
									</div>
								<div class="stop_float"></div>
								<div class="overflow">
									<h2>Merci</h2>';
							$qme = $conn->query('SELECT Merce.id, tipo, quantita, valore FROM Merce, trasporta WHERE merce = Merce.id AND tappa = '.$tappa);
							$totmerc = $qme->num_rows;
							if ($totmerc == 0) {
								echo '<p>Nessun merce inserita fin ora.</p>';
							} else {
								echo '<ul>';
								for ($me = 0; $me < $totmerc; $me++) {
									$merc = $qme->fetch_row();
									echo '<li>';
									if ($merc[2] != null) {
										echo $merc[2].' di ';
									};
									echo $merc[1];
									if ($merc[3] != null) {
										echo ' ('.$merc[3].')';
									};
									echo '<input class="interact" type="button" value="X" onclick="elimina_trasporta('.$merc[0].', '.$tappa.')"/></li>';
								};
								echo '</ul>';
							};
							echo '<input type="button" value="Nuova merce" onclick="crea_trasporta('.$tappa.')">
									</div>';
						} else {
							echo '<div>
									<p>Altri dati saranno disponibili una volta forniti quelli fondamentali.</p>
								</div>';
};
						break;
					case 'lp': // Luogo partenza
						echo '<div>
								<h1>Luogo partenza della tappa</h1>
								<p>Il luogo da cui è partita la tappa, se è la tappa è in posizione 1 coincide con il luogo di partenza del viaggio.<br/>Si può selezionare dall\'elenco, ricercare nel database o inserirne di nuovi trovandoli su siti autorevoli o scegliendoli dalla mappa.</p>
							</div>
							<div id="pop_lp_tappa">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_lp_tappa" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<div><input type="radio" id="lp'.$luog[0].'" name="lp_tappa" value="'.$luog[0].'"> <label for="lp'.$luog[0].'">'.$luog[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="lp_tappa_search">Cerca nel database:</label>
								</br>
								<input type="text" list="lp_tappa_list" id="lp_tappa_search" name="lp_tappa_search">
								<datalist id="lp_tappa_list">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<option data-id="'.$luog[0].'" value="'.$luog[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="luogo_search(\'lp\')">
								<input type="text" id="lp_tappa_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuovo" onclick="apri_insert(\'lp\', this)">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$tappa.', \'lp\')"/>
							</div>';
						break;
					case 'la': // Luogo arrivo
						echo '<div>
								<h1>Luogo arrivo della tappa</h1>
								<p>Il luogo a cui è arrivata la tappa, nonché il luogo di partenza della tappa in posizione successiva.<br/>Si può selezionare dall\'elenco, ricercare nel database o inserirne di nuovi trovandoli su siti autorevoli o scegliendoli dalla mappa.</p>
							</div>
							<div id="pop_la_tappa">
								<div class="dropdown">
									<input type="button" value="Scegli dall&#8217;elenco">
									<div id="ddc_la_tappa" class="dropdown_content">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<div><input type="radio" id="la'.$luog[0].'" name="la_tappa" value="'.$luog[0].'"> <label for="la'.$luog[0].'">'.$luog[1].'</label></div>';
						};
						echo '</div>
							</div>
							<div class="blank_space"></div>
								<h3>Se non hai trovato quello che cerchi</h3>
								<label for="la_tappa_search">Cerca nel database:</label>
								</br>
								<input type="text" list="la_tappa_list" id="la_tappa_search" name="la_tappa_search">
								<datalist id="la_tappa_list">';
						$q = $conn->query('SELECT id, nome FROM Luogo ORDER BY nome');
						$totluog = $q->num_rows;
						for ($l = 0; $l < $totluog; $l++) {
							$luog = $q->fetch_row();
							echo '<option data-id="'.$luog[0].'" value="'.$luog[1].'">';
						};
						echo '</datalist>
								</br>
								<input type="button" value="Seleziona" onclick="luogo_search(\'la\')">
								<input type="text" id="la_tappa_selected" hidden="hidden">
								</br>
								</br>
								<input type="button" value="Inserisci nuovo" onclick="apri_insert(\'la\', this)">
							</div>
							<div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$tappa.', \'la\')"/>
							</div>';
						break;
					case 'dp': // Data partenza
						echo '<div>
								<h1>Data di partenza del viaggio</h1>
								<p>Data in cui è stato lasciato il luogo di partenza della tappa: da inserire solo se più specifica rispetto a quelle del viaggio.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra secoli e quarti di secoli.</p>
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
								<input type="button" value="Invia" id="invia" onclick="invia_campo('.$tappa.', \'dp\')"/>
							</div>';
						break;
					case 'da': // Data arrivo
						echo '<div>
								<h1>Data di arrivo del viaggio</h1>
								<p>Data in cui si è entrati nel luogo di arrivo della tappa: da inserire solo se più specifica rispetto a quelle del viaggio.<br/>Si può scegliere se inserire la data completa, anno e mese, solo anno o invece scegliere fra secoli e quarti di secoli.</p>
								<label for="tipo">Tipo di data:</label><br/>
								<div class="dropdown"> 
									<input type="button" id="tipo" value="Scegli dall&#8217;elenco" onclick="pop_hover(this)"/> 
									<div class="dropdown_content">
										<div><input type="radio" id="data" name="tipo" value="data" onclick="scegli_tipo(this.id, \'da\')" <label for="data">Data completa</label></div>
										<div><input type="radio" id="anno_mese" name="tipo" value="anno_mese" onclick="scegli_tipo(this.id, \'da\')" <label for="anno_mese">Anno e mese</label></div>
										<div><input type="radio" id="anno" name="tipo" value="anno" onclick="scegli_tipo(this.id, \'da\')" <label for="anno">Solo anno</label></div>
										<div><input type="radio" id="intervallo" name="tipo" value="intervallo" onclick="scegli_tipo(this.id, \'da\')" <label for="web">Intervallo</label></div>
									</div>
								</div>
								<div class="blank_space"></div>
								<div id="campi_data">
								</div>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$tappa.', \'da\')"/>
							</div>';
						break;
					case 'pag': // Pagine
						echo '<div>
								<h1>Pagine della tappa</h1>
								<p>Le pagine specifiche della fonte che parlano della tappa. <br/> La stringa deve inziare per "p." nel caso si tratti di una sola pagina o "pp." nel caso siano più di una. <br/>Nel caso di intervalli si indicano con "-" e si fa riferimento a più di uno allora si dividono fra loro con virgole e la congiunzione "e".</p>
								<input type="input" id="pag"/><br/>
								<input type="button" value="Invia" id="invia"  onclick="invia_campo('.$tappa.', \'pag\')"/>
							</div>';
						break;
					default:
						break;
				}
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
