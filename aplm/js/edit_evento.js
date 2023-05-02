// FUNZIONI MODIFICA DI UN CAMPO DELL'EVENTO //////////////////////////////////
function modifica_campo(idEvento, campo) {
	window.location.assign("edit_evento.php?id=" + idEvento + "&campo=" + campo);
};

function invia_campo(idEvento, campo, versione = null) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', idEvento);
	switch (campo) {
		case 'ti':
			dati.set('campo', 'titolo');
			var tito = document.getElementById('ti').value;
			if (tito != "") {
				dati.append('valore', tito);
			} else {
				flagErrore = true;
			};
			break;
		case 'dd':
			dati.set('campo', 'didascalia');
			var dida = document.getElementById('dd').value;
			if (dida != "") {
				dati.append('valore', dida);
			} else {
				flagErrore = true;
			};
			break;
		case 'di':
			dati.set('campo', 'data_inizio');
			dati.set('tipo', versione);
			if (versione== 'anno') {
				if (document.getElementById('ins_anno').value == "" ||
					document.getElementById('ins_anno').value < 476 ||
					document.getElementById('ins_anno').value > 1492) {
					flagErrore = true;
				} else {
					var aaaa = document.getElementById('ins_anno').value;
					if (aaaa < 1000) {
						dati.set('valore', '0' + aaaa + '-00-00');
					} else {
						dati.set('valore', aaaa + '-00-00');
					};
				};
			} else if (versione == 'anno_mese') {
				if (document.getElementById('ins_anno').value == "" ||
					document.getElementById('ins_anno').value < 476 ||
					document.getElementById('ins_anno').value > 1492 ||
					document.getElementById('ins_mese').value == "" ||
					document.getElementById('ins_mese').value < 1 ||
					document.getElementById('ins_mese').value > 12) {
					flagErrore = true;
				} else {
					var aaaa = document.getElementById('ins_anno').value;
					var mm = document.getElementById('ins_mese').value;
					var val_anno = aaaa;
					var val_mese = mm;
					if (aaaa < 1000) {
						val_anno = '0' + aaaa;
					};
					if (mm < 10) {
						val_mese = '0' + mm;
					};
					dati.set('valore', val_anno + '-' + val_mese + '-00');
				};
			} else if (versione == 'data') { 
				if (document.getElementById('ins_data').value == ""||
					document.getElementById('ins_data').value < '0476-09-04' ||
					document.getElementById('ins_data').value > '1492-10-12') {
					flagErrore = true;
				} else {
					var data = document.getElementById('ins_data').value;
					dati.set('valore', data);
				};
 			} else if (versione == 'intervallo') {
				if (document.querySelector('input[name="int"]:checked')) {
					var check_radio = document.querySelector('input[name="int"]:checked').value;
					dati.set('valore', check_radio);
				};
			} else {
				alert('Errore!');
			};
			break;
		case 'df':
			dati.set('campo', 'data_fine');
			dati.set('tipo', versione);
			if (versione== 'anno') {
				if (document.getElementById('ins_anno').value == "" ||
					document.getElementById('ins_anno').value < 476 ||
					document.getElementById('ins_anno').value > 1492) {
					flagErrore = true;
				} else {
					var aaaa = document.getElementById('ins_anno').value;
					if (aaaa < 1000) {
						dati.set('valore', '0' + aaaa + '-00-00');
					} else {
						dati.set('valore', aaaa + '-00-00');
					};
				};
			} else if (versione == 'anno_mese') {
				if (document.getElementById('ins_anno').value == "" ||
					document.getElementById('ins_anno').value < 476 ||
					document.getElementById('ins_anno').value > 1492 ||
					document.getElementById('ins_mese').value == "" ||
					document.getElementById('ins_mese').value < 1 ||
					document.getElementById('ins_mese').value > 12) {
					flagErrore = true;
				} else {
					var aaaa = document.getElementById('ins_anno').value;
					var mm = document.getElementById('ins_mese').value;
					var val_anno = aaaa;
					var val_mese = mm;
					if (aaaa < 1000) {
						val_anno = '0' + aaaa;
					};
					if (mm < 10) {
						val_mese = '0' + mm;
					};
					dati.set('valore', val_anno + '-' + val_mese + '-00');
				};
			} else if (versione == 'data') { 
				if (document.getElementById('ins_data').value == ""||
					document.getElementById('ins_data').value < '0476-09-04' ||
					document.getElementById('ins_data').value > '1492-10-12') {
					flagErrore = true;
				} else {
					var data = document.getElementById('ins_data').value;
					dati.set('valore', data);
				};
 			} else {
				alert('Errore!');
			};
			break;
		case 'im':
			dati.set('campo', 'immagine');
			if (document.querySelector('input[name="im_even"]:checked')) {
				var check_radio = document.querySelector('input[name="im_even"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('im_even_selected').value != "") {
				var check_select = document.getElementById('im_even_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'uri':
			dati.set('campo', 'uri');
			var uri = document.getElementById('uri').value;
			if (uri != "") {
				dati.append('valore', uri);
			} else {
				flagErrore = true;
			};
			break;
		default:
			alert('Errore!');
			break;
	};
	if (flagErrore == false) {
		$.ajax({
			type: "POST",
			url: "php/modifica_campo_evento.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ != 'Viaggio 1 e Viaggio 2 sono uguali.') {
					window.location.assign("edit_evento.php?id=" + idEvento);
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	} else {
		alert('Inserisci correttamente i campi.');
	};
};

// LISTA PER GLI INTERVALLI DI DATE ///////////////////////////////////////////
var DBinter = [];
var DBimmag = [];

// FUNZIONI PER L'AGGIUNTA DI NUOVE ENTITA' NEL DATABASE //////////////////////
function aggiornaDB(tipo) {
	DBimmag = [];
	$.ajax({
		type: "POST",
		url: "php/trova_immagini.php",
		success: function (resJ) {
			var res = JSON.parse(resJ);
			for (immag of res) {
				DBimmag.push(immag);
			};
		},
		processData: false,
		contentType: false,
		async: false
	});
};

// FUNZIONI PER LA GESTIONE DELLE DATE ////////////////////////////////////////
function scegli_tipo(versione, tipoOgg) {
	var nodo_campi = document.getElementById('campi_data');
	var nodo_invia = document.getElementById('invia');
	var tappa = new URLSearchParams(window.location.search).get('id');
	nodo_campi.innerHTML = "";
	switch (versione) {
		case "anno":
			nodo_campi.innerHTML = '<form id="form_data"> \
										<h2>Solo anno</h2> \
										<p>Anni compresi fra il 476 e il 1492.</p>\
										<input type="number" id="ins_anno" name="ins_anno" min="476" max="1492"/> \
									</form>';
			nodo_invia.setAttribute('onclick', 'invia_campo(' + tappa + ', \'' + tipoOgg +'\', \'anno\')');
			break;
		case "anno_mese":
			nodo_campi.innerHTML = '<form id="form_data"> \
										<h2>Anno e mese</h2> \
										<p>Anni compresi fra il 476 e il 1492.</p>\
										<table> \
											<tr><th>Anno:</th><td><input type="number" id="ins_anno" name="ins_anno" min="476" max="1492"/></td></tr> \
											<tr><th>Mese:</th><td><input type="number" id="ins_mese" name="ins_mese" min="1" max="12"/></tr> \
										</table> \
									</form>';
			nodo_invia.setAttribute('onclick', 'invia_campo(' + tappa + ', \'' + tipoOgg +'\', \'anno_mese\')');
			break;
		case "data":
			nodo_campi.innerHTML = '<form id="form_data"> \
										<h2>Data completa</h2> \
										<p>Anni compresi fra il 476 e il 1492.</p>\
										<input type="date" id="ins_data" name="ins_data"/>\
									</form>';
			nodo_invia.setAttribute('onclick', 'invia_campo(' + tappa + ', \'' + tipoOgg +'\', \'data\')');
			break;
		default:
			alert('Errore!');
			break;
	};
};

// FUNZIONI PER LA GESTIONE DELLE IMMAGINI ////////////////////////////////////
function imm_search() {
	var searchId = "im_even_search";
	var listId = "im_even_list";
	var selectId = "im_even_selected";
	var immS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var immId = document.querySelector("#" + listId + " option[value='" + immS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("L'immagine non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Immagine selezionata.");
		document.getElementById(selectId).value = immId;
	};
};

function insert_imm() {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var form = document.getElementById('insert_imma');
	var dati = new FormData(form);
	var errori = new Array;
	if (dati.get("titolo").length == 0 || dati.get("titolo").match(/[^a-zA-Z0-9] ]/)) {
		errori.push("titolo");
	};
	if (dati.get("didascalia").length == 0) {
		errori.push("didascalia");
	};
	if (dati.get("provenienza").length == 0) {
		errori.push("provenienza");
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_immagine.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (!['Titolo già presente.', 'Estensione non supportata.', 'Risoluzione troppo alta.', 'Immagine troppo pesante.', 'Nessuna immagine caricata.'].includes(resJ)) {
					return_back('im', nodo);
					var selectId = "im_even_selected";
					var searchId = "im_even_search";
					document.getElementById(selectId).value = res[0]; // id recuperato
					document.getElementById(searchId).value = res[1]; // didascalia recuperata
					alert("Immagine selezionata.");
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	} else {
		for (var i = 0; i < errori.length; i++) {
			if (i != errori.length - 1) { 
				messaggio = messaggio + " " + errori[i] + ",";
			} else {
				messaggio = messaggio + " " + errori[i] + ".";
			};
		};
		alert(messaggio);
	};
};

function return_back(tipoOgg, nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	if (tipoOgg == "im") { // immagine
		var nodoDiv = document.getElementById('pop_im_even');
		nodoDiv.innerHTML = "";
		aggiornaDB(0); // aggiornamento elenchi delle immagini
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<div class='dropdown'> \
								<input type='button' value='Scegli dall&#8217;elenco'> \
								<div id='ddc_im_even' class='dropdown_content'></div> \
							</div> \
							<div class='blank_space'></div> \
							<h3>Se non hai trovato quello che cerchi</h3> \
							<label for='im_even_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='im_even_list' id='im_even_search' name='im_even_search'> \
							<datalist id='im_even_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='imm_search()'> \
							<input type='text' id='im_even_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Inserisci nuovo' onclick='apri_insert(\"im\", this)'>";
		var radio_im = "";
		var optio = "";
		var rlist_im = document.getElementById('ddc_im_even');
		var dlist_im = document.getElementById('im_even_list');
		rlist_im.innerHTML = "";
		dlist_im.innerHTML = "";
		for (var i = 0; i < DBimmag.length; i++) {
			radio_im = "<div><input type='radio' id='im" + DBimmag[i][0] + "' name='im' value='" + DBimmag[i][0] + "'> <label for='im" + DBimmag[i][0] + "'><img src='" + DBimmag[i][1] + "'style='max-width: 180px; max-height:180px'>" + DBimmag[i][2] +"</label></div>";
			rlist_im.insertAdjacentHTML('beforeend', radio_im);
			optio = "<option data-id='" + DBimmag[i][0] + "' value='" + DBimmag[i][2] + "'>";
			dlist_im.insertAdjacentHTML('beforeend', optio);
		};
	}
};

function apri_insert(tipo, nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	if (tipo == 'im') { // immagine
		nodoDiv.innerHTML = "<a href='#' onclick='return_back(\"" + tipo + "\", this)'>Torna alla scelta dell&#8217;immagine</a>";
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<p>Il titolo del file deve essere composto solo da lettere e numeri (no spazi e caratteri speciali);<br/>il file deve essere di dimensioni massime 1024x768, pesare meno di 2MB ed essere un jpg, un png o un gif;<br/>la didascalia è una breve spiegazione dell’immagine;<br/>la provenienza dove è conservata.</p>\
							<form id='insert_imma'> \
								<label for='titolo'>Titolo:</label> \
								</br> \
								<input type='text' id='titolo' name='titolo' maxlength='100'> \
								</br> \
								<label for='im_file'>File:</label> \
								<br/> \
								<input type='file' id='im_file' name='im_file'/> \
								<br/> \
								<label for='didascalia'>Didascalia:</label> \
								</br> \
								<input type='text' id='didascalia' name='didascalia' maxlength='256'> \
								</br> \
								<label for='provenienza'>Provenienza:</label> \
								</br> \
								<input type='text' id='provenienza' name='provenienza' maxlength='256'> \
							</form> \
							</br> \
							<input type='button' id='insert_i' value='Inserisci' onclick='insert_imm(this)'> </br></br>"
	};
};
