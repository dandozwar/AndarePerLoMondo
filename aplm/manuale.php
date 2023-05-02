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
?>
<html lang="it">
	<head>
		<meta charset="UTF-8"/>
		<link rel="icon" href="./img/LogoAPLM.png"/>
		<link rel="stylesheet" type="text/css" href="./css/general.css" />
		<link rel="stylesheet" type="text/css" href="./css/popover.css" />
		<script src="./js/popover.js"></script>
		<script src="./js/accedi.js"></script>
		<script src="./js/background.js"></script>
		<title>APLM - Manuale utente</title>
		<meta name="author" content="Alessandro Cignoni"/>
		<meta name="description" content="Andare per lo mondo: manuale utente"/>
	</head>
	<body>
		<header>
			<h1>Andare per lo mondo</h1>
				<a href="./index.php" target="_blank"><img src="./img/LogoAPLM.png" id="logo1" class="stemmi" title="Andare per lo mondo"/></a>
				<a href="http://www.labcd.unipi.it/" target="_blank"><img src="./img/LogoLabCD.png" id="logo2" class="stemmi" title="Laboratorio Cultura Digitale"/></a>
			<ul id = "breadcrumb" class="breadcrumb">
				<ul id = "breadcrumb" class="breadcrumb">
				<?php
					echo '<li><a href="./index.php">Home</a></li>
							<li><a href="./pagina_personale.php?user='.$_SESSION["nick"].'">Pagina personale</a></li>
							<li>Manuale utente</li>';
				?>
			</ul>
		</header>
		<div>
			<h1>Manuale utente</h1>
			<h2>Paragrafi:</h2>
			<ol>
				<li><a href="#intro">Introduzione</a></li>
				<li><a href="#fapre">Fase preliminare</a></li>
				<ol>
					<li><a href="#selez">Selezione</a></li>
					<li><a href="#risto">Ricerca storica</a></li>
				</ol>
				<li><a href="#fains">Fase di inserimento</a></li>
				<ol>
					<li><a href="#perso">Persona</a></li>
					<li><a href="#scopo">Scopo</a></li>
					<li><a href="#viagg">Viaggio</a></li>
					<li><a href="#biogr">Biografia</a></li>
				</ol>
			</ol>
			<div id="intro">
				<h2>1 Introduzione</h2>
				<p>Benvenuto su Andare per lo mondo! Se ti trovi su questa pagina significa che vuoi contribuire e inserire viaggi e biografie medievali al database. Qui troverai una breve guida su come inserire nella maniera più efficiente i dati.</p>
				<p>Per inserire un viaggio su Andare per lo mondo sono previste due fasi di lavoro, una prima fuori dal sito e una successiva su di esso, chiameremo la prima <em>"Fase preliminare"</em> e la successiva <em>"Fase di inserimento"</em>.
			</div>
			<div id="fapre">
				<h2>2 Fase preliminare</h2>
				<div id="selez">
				<h3>2.1 Selezione</h3>
					<p>In primo luogo dobbiamo sapere se il viaggio che si vuole inserire è adatto ad Andare per lo mondo. Quello che si intende è che deve essere un viaggio <em>medievale</em>, di cui sono documentate le <em>singole tappe</em> in maniera precisa e puntuale, ovvero di cui non solo si deve sapere la località di partenze e la località di fine, ma anche queste possano essere individuate con delle coordinate geografiche.</p>
				</div>
				<div id="risto">
					<h3>2.2 Ricerca storica</h3>
					<p>Trovato il viaggio che si vuole inserire sul sito si deve individuare, tramite una fonte online certificabile (<a href="https://www.treccani.it/enciclopedia/elenco-opere/Dizionario_Biografico" target="_blank">Dizionario Biografico degli italiani</a>, l’<a href="https://www.treccani.it/enciclopedia/" target="_blank">Enciclopedia Treccani</a> o <a href="https://www.wikidata.org/wiki/Wikidata:Main_Page" target="_blank">Wikidata</a>):
						<ol>
							<li><em>partecipanti</em>  del viaggio e delle singole tappe, corredati di luogo e data di nascita e morte, di relazioni fra di loro e occupazioni che hanno svolto nel corso della vita;</li>
							<li><em>scopi</em> che hanno portato a compiere il viaggio o la singola tappa, corredati di mandanti e destinatari;</li>
							<li><em>singole tappe</em> del viaggio, intese come spostamento fra un luogo di partenza e un luogo di arrivo;</li>
							<li><em>merci</em> trasportate nelle singole tappe.</li>
						</ol>
					</p>
					<p>Nel caso si inseriscano più viaggi di una stessa persona si può valutare di creare una <em>biografia</em>, in tal caso è necessario individuare gli <em>eventi</em> principali della vita della persona, una fonte autorevole online che li certifichi e, se lo si desidera, anche delle immagini da allegare a essi (purché provengano da <a href="https://commons.wikimedia.org/wiki/Main_Page" target="_blank">Wikimedia</a> o siano di proprietà dell'utente).</p>
				</div>
			</div>
			<div id="fains">
				<h2>3 Fase di inserimento</h2>
				<p>Dalla propria pagina utente è possibile gestire tutte le entità che l'utente ha inserito nel database. Seguendo il workflow raccomandato le analizzeremo una ad una.</p>
				<p>In generale si può modificare un'entità cliccando sul pulsante di interazione "&#9998;", la si può eliminare cliccando su quello "X" e se ne può creare una nuova con il pulsante in fondo all'elenco "Crea".</p>
				<div id="perso">
					<h3>3.1 Persona</h3>
					<p>Tutte le altre entità del database si basano su di questa, quindi è fondamentale creare, o valutare se già esistono, tutte le persone che sono coinvolte nel viaggio, nelle tappe e nei suoi scopi.</p>
					<p>Le persone sono risorse condivise, il che significa che solo l'utente che le ha inserite nel database può modificarle, ma tutti possono riusarle nei loro viaggi, nelle tappe o scopi.</p>
					<ul>
						<li>Dalla <em>pagina utente</em> si può creare, eliminare e avviare la modifica.</li>
						<li>Dalla pagina <em>modifica persona</em> si possono cambiare i suoi campi e, una volta inseriti quelli fondamentali, creare ed eliminare di relazioni e occupazioni; infine si può anche avviare la modifica delle relazioni.</li>
						<li>Dalla pagina <em>modifica relazione</em> si possono cambiare i suoi campi e inserire nel database nuovi tipi di relazione.</li>
						<li>Dalla pagina <em>aggiungi occupazione</em> si possono finire di creare e inserire nel database nuovi tipi di occupazioni.</li>
					</ul>
				</div>
				<div id="scopo">
					<h3>3.2 Scopo</h3>
					<p>Prima di poter scegliere gli scopi per un viaggio è necessario inserirli nel database se non sono già presenti.</p>
					<p>Gli scopi sono risorse condivise, il che significa che solo l'utente che le ha inserite nel database può modificarle, ma tutti possono riusarle nei loro viaggi o tappe.</p>
					<ul>
						<li>Dalla <em>pagina utente</em> si può creare, eliminare e avviare la modifica.</li>
						<li>Dalla pagina <em>modifica scopo</em> si possono cambiare i suoi campi e, una volta inseriti quelli fondamentali, creare ed eliminare i destinatari e i mandanti o inserire nuovi tipi di scopo.</li>
						<li>Dalla pagina <em>aggiungi destinatario</em> si può scegliere una persona destinatario dello scopo.</li>
						<li>Dalla pagina <em>aggiungi mandante</em> si può scegliere una persona mandante dello scopo.</li>
					</ul>
				</div>
				<div id="viagg">
					<h3>3.3 Viaggio</h3>
					<p>I viaggi compariranno nelle eventuali biografie delle persone che hanno partecipato; una persona partecipa al viaggio se è presente in tutte le tappe.</p>
					<p>I luoghi sono risorse condivise, non hanno un'attribuzione dell'utente che le ha inserite; le fonti invece sono proprietarie, quindi è possibile copiare ed eventualmente modificare dalla pagina utente le fonti altrui.</p>
					<ul>
						<li>Dalla <em>pagina utente</em> si può creare, eliminare e avviare la modifica.</li>
						<li>Dalla pagina <em>modifica viaggio</em> si possono cambiare i suoi campi e, una volta inseriti quelli fondamentali, si può descrivere più dettagliatamente il piano e decidere se il viaggio può essere visto dagli altri utenti; si può poi creare ed eliminare le tappe, gli scopi e i partecipanti; si può anche inserire nuovi luoghi e fonti, in particolare queste ultime possono essere del tutto nuove o copiate da quelle di altri utenti; infine si può anche avviare la modifica delle tappe. Una volta inserita una tappa verrà assegnata una posizione di questa all'interno del viaggio, che non potrà più essere modificata</li>
						<li>Dalla pagina <em>modifica tappa</em> si possono cambiare i suoi campi e, una volta inseriti quelli fondamentali, aggiungere le date, creare ed eliminare partecipanti della singola tappa, scopi e merci.</li>
						<li>Dalla pagina <em>aggiungi partecipante</em> si può scegliere una persona mandante dello scopo.</li>
						<li>Dalla pagina <em>aggiungi motivo</em> si può scegliere uno scopo per la singola tappa.</li>
						<li>Dalla pagina <em>aggiungi merce</em> si può scegliere una merce o aggiungerne una nuova.</li>
					</ul>
				</div>
				<div id="biogr">
					<h3>3.4 Biografia</h3>
					<p>Le biografie sono composte da slides generate sulla base dei dati inseriti per ogni singolo evento e dai viaggi a cui la persona a partecipato.</p>
					<ul>
						<li>Dalla <em>pagina utente</em> si può creare, eliminare e avviare la modifica.</li>
						<li>Dalla pagina <em>modifica biografia</em> si possono cambiare i suoi campi e, una volta inseriti quelli fondamentali, si possono scegliere due viaggi significativi fra quelli inseriti e decidere se la biografia può essere vista dagli altri utenti; si può poi creare, eliminare e avviare la modifica degli eventi.</li>
						<li>Dalla pagina <em>modifica evento</em> si possono cambiare i suoi campi e, una volta inseriti quelli fondamentali, aggiungere la data di fine o caricare un'immagine.</li>
					</ul>
				</div>
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
