// FUNZIONI MODIFICA DI UN CAMPO DELLA BIOGRAFIA //////////////////////////////
function modifica_campo(relazione, campo) {
	window.location.assign("edit_relazione.php?id=" + relazione + "&campo=" + campo);
};

function invia_campo(idRela, campo, versione = null) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', idRela);
	switch (campo) {
		case 'ti':
			dati.set('campo', 'tipo');
			if (document.querySelector('input[name="tipo_rela"]:checked')) {
				var check_radio = document.querySelector('input[name="tipo_rela"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('tipo_rela_selected').value != "") {
				var check_select = document.getElementById('tipo_rela_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'p2':
			dati.set('campo', 'persona2');
			if (document.querySelector('input[name="p2_rela"]:checked')) {
				var check_radio = document.querySelector('input[name="p2_rela"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('p2_rela_selected').value != "") {
				var check_select = document.getElementById('p2_rela_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'di':
			dati.set('campo', 'data_inizio');
			dati.set('tipo', versione);
			if (versione == 'anno') {
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
				} else {
					flagErrore = true;
				};
			} else {
				alert('Errore!');
			};
			break;
		case 'df':
			dati.set('campo', 'data_fine');
			dati.set('tipo', versione);
			if (versione == 'anno') {
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
				} else {
					flagErrore = true;
				};
			} else {
				alert('Errore!');
			};
			break;
		default:
			alert('Errore!');
			break;
	};
	if (flagErrore == false) {
		$.ajax({
			type: "POST",
			url: "php/modifica_campo_relazione.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Modifica effettuata.') {
					window.location.assign("edit_relazione.php?id=" + idRela);
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

// LISTE PER L'AGGIUNTA DI NUOVE ENTITA' NEL DATABASE /////////////////////////
var DBtiporel = [];
var DBinter = [];

// FUNZIONI PER L'AGGIUNTA DI NUOVE ENTITA' NEL DATABASE //////////////////////
function aggiornaDB(tipo) {
	if (tipo == 0) {
		DBtiporel = [];
		$.ajax({
			type: "POST",
			url: "php/trova_tipi_relazioni.php",
			success: function (resJ) {
				var res = JSON.parse(resJ);
				for (occup of res) {
						DBtiporel.push(occup);
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	} else if (tipo == 2) {
		DBinter = [];
		$.ajax({
			type: "POST",
			url: "php/trova_intervalli.php",
			success: function (resJ) {
				var res = JSON.parse(resJ);
				for (inter of res) {
					DBinter.push(inter);
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	};
};

// FUNZIONI DI GESTIONE DELLE PERSONE /////////////////////////////////////////
function pers_search() {
	var searchId = "p2_rela_search";
	var listId = "p2_rela_list";
	var selectId = "p2_rela_selected";
	var persS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var persId = document.querySelector("#" + listId + " option[value='" + persS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("La persona non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Persona selezionata.");
		document.getElementById(selectId).value = persId;
		var tipoLuogo = tipo.concat(persId);
	};
};

// FUNZIONI DI GESTIONE DELLE DATE ////////////////////////////////////////////
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
		case "intervallo":
			aggiornaDB(2); // scarica tutti gli intervalli
			nodo_campi.innerHTML = '<form id="form_data"> \
									<h2>Intervallo</h2>\
									<p>Anni compresi fra il 476 e il 1492.</p>\
									<div class="dropdown"> \
										<input type="button" value="Scegli dall&#8217;elenco"><br/> \
										<div id="ddc_intervallo" class="dropdown_content"></div> \
										<div class="blank_space"></div> \
									</div> \
								</form>';
			var radio_int = "";
			var optio = "";
			var rlist_int = document.getElementById('ddc_intervallo');
			rlist_int.innerHTML = "";
			for (var i = 0; i < DBinter.length; i++) {
				radio_int = "<div><input type='radio' id='int" + DBinter[i][0] + "' name='int' value='" + DBinter[i][0] + "'> <label for='int" + DBinter[i][0] + "'>" + DBinter[i][1] + "</label></div>";
				rlist_int.insertAdjacentHTML('beforeend', radio_int);
			};
			nodo_invia.setAttribute('onclick', 'invia_campo(' + tappa + ', \'' + tipoOgg +'\', \'intervallo\')');
			break;
		default:
			alert('Errore!');
			break;
	};
};

// FUNZIONI DI GESTIONE DEI TIPI DI RELAZIONE /////////////////////////////////
function return_back(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var nodoDiv = document.getElementById('pop_tipo_rela');
	nodoDiv.innerHTML = "";
	aggiornaDB(0); // aggiornamento elenchi del tipo relazioni
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<div class='dropdown'> \
						<input type='button' value='Scegli dall&#8217;elenco'> \
						<div id='ddc_tipo_rela' class='dropdown_content'></div> \
						</div> \
						<div class='blank_space'></div> \
						<h3>Se non hai trovato quello che cerchi</h3> \
						<label for='tipo_rela_search'>Cerca nel database:</label> \
						</br> \
						<input type='text' list='tipo_rela_list' id='tipo_rela_search' name='tipo_rela_search'> \
						<datalist id='tipo_rela_list'> \
						</datalist> \
						</br> \
						<input type='button' value='Seleziona' onclick='tipo_search()'> \
						<input type='text' id='tipo_rela_selected' hidden='hidden'> \
						</br> \
						</br> \
						<input type='button' value='Inserisci nuovo' onclick='apri_insert(this)'>\
						</br> \
						</br>";
	var radio_tire = "";
	var optio = "";
	var rlist_tire = document.getElementById('ddc_tipo_rela');
	var dlist_tire = document.getElementById('tipo_rela_list');
	rlist_tire.innerHTML = "";
	dlist_tire.innerHTML = "";
	for (var t = 0; t < DBtiporel.length; t++) {
		radio_tire = "<div><input type='radio' id='tr" + DBtiporel[t][0] + "' name='tipo_rela' value='" + DBtiporel[t][0] + "'> <label for='occu" + DBtiporel[t][0] + "'>" + DBtiporel[t][1] + "</label></div>";
		rlist_tire.insertAdjacentHTML('beforeend', radio_tire);
		optio = "<option data-id='" + DBtiporel[t][0] + "' value='" + DBtiporel[t][1] + "'>";
		dlist_tire.insertAdjacentHTML('beforeend', optio);
	};
};

function apri_insert(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<a href='#' onclick='return_back(this)'>Torna alla scelta del tipo relazione</a>";
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<p>Inserire il tipo.</p> \
						<form id='insert_tipo_rela'> \
							<label for='tipo'>Tipo relazione:</label> \
							</br> \
							<input type='text' id='tipo' name='tipo_rela' maxlength=64'> \
						</form> \
						</br> \
						<input type='button' id='insert_t' value='Inserisci' onclick='insert_tipo(this)'>";
};

function tipo_search() {
	var searchId = "tipo_rela_search";
	var listId = "tipo_rela_list";
	var selectId = "tipo_rela_selected";
	var tipoS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var tipoId = document.querySelector("#" + listId + " option[value='" + tipoS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("Il tipo relazione non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Tipo relazione selezionato.");
		document.getElementById(selectId).value = tipoId;
	};
};

function insert_tipo(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var res;
	var form = document.getElementById("insert_tipo_rela");
	var dati = new FormData(form);
	var errori = new Array;
	var messaggio = "Inserisci correttamente: ";
	if (dati.get("tipo_rela").length == 0) {
		errori.push("tipo relazione");
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_tipo_relazione.php",
			data: dati,
			success: function (resJ) {
				if (resJ != 'Tipo relazone già inserito.') {
					return_back(nodo);
					res = JSON.parse(resJ);
					var selectId = "tipo_rela_selected";
					var searchId = "tipo_rela_search";
					document.getElementById(selectId).value = res[0]; // id recuperato
					document.getElementById(searchId).value = res[1]; // nome recuperato
					alert("Tipo relazione selezionato.");
				} else {
					alert(resJ);
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
