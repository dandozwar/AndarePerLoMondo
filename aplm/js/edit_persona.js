// FUNZIONI GESTIONE DI UNA BIOGRAFIA /////////////////////////////////////////
function modifica_bio(idPersona) {
	window.location.assign("edit_biografia.php?persona=" + idPersona + "");
};

function elimina_bio(idPersona) {
	if (confirm('Eliminare definitivamente questa biografia?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_biografia.php',
			data: {'persona': idPersona},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Biografia eliminata.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_bio(idPersona) {
	var res;
	$.ajax({
		type: 'POST',
		url: 'php/insert_biografia.php',
		data: {'persona': idPersona},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) {
				modifica_bio(res[0]);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

// FUNZIONI GESTIONE DI UN'OCCUPAZIONE ////////////////////////////////////////
function modifica_occu(idOccu) {
	window.location.assign("edit_lavora_come.php?id=" + idOccu + "");
};

function elimina_occu(idOccu) {
	if (confirm('Eliminare definitivamente questa occupazione?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_lavora_come.php',
			data: {'id': idOccu},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Occupazione eliminata.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_occu(idPersona) {
	var res;
	$.ajax({
		type: 'POST',
		url: 'php/insert_lavora_come.php',
		data: {'persona': idPersona},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) {
				modifica_occu(res[0]);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

// FUNZIONI GESTIONE DI UNA RELAZIONE /////////////////////////////////////////
function modifica_rela(idRela) {
	window.location.assign("edit_relazione.php?id=" + idRela + "");
};

function elimina_rela(idRela) {
	if (confirm('Eliminare definitivamente questa relazione?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_relazione.php',
			data: {'id': idRela},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Relazione eliminata.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_rela(idPersona) {
	var res;
	$.ajax({
		type: 'POST',
		url: 'php/insert_relazione.php',
		data: {'persona1': idPersona},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) {
				modifica_rela(res[0]);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

// FUNZIONI MODIFICA DI UN CAMPO DELLA PERSONA ////////////////////////////////
function modifica_campo(id, campo) {
	window.location.assign("edit_persona.php?id=" + id + "&campo=" + campo);
};

function invia_campo(id, campo, versione = null) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	switch (campo) {
		case 'no':
			dati.set('campo', 'nome');
			var nome = document.getElementById('no').value;
			if (nome != "") {
				dati.append('valore', nome);
			} else {
				flagErrore = true;
			};
			break;
		case 'co':
			dati.set('campo', 'cognome');
			var cognome = document.getElementById('co').value;
			if (cognome != "") {
				dati.append('valore', cognome);
			} else {
				flagErrore = true;
			};
			break;
		case 'so':
			dati.set('campo', 'soprannome');
			var soprannome = document.getElementById('so').value;
			if (soprannome != "") {
				dati.append('valore', soprannome);
			} else {
				flagErrore = true;
			};
			break;
		case 'ln':
			dati.set('campo', 'luogo_nascita');
			if (document.querySelector('input[name="ln_pers"]:checked')) {
				var check_radio = document.querySelector('input[name="ln_pers"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('ln_pers_selected').value != "") {
				var check_select = document.getElementById('ln_pers_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'lm':
			dati.set('campo', 'luogo_morte');
			if (document.querySelector('input[name="lm_pers"]:checked')) {
				var check_radio = document.querySelector('input[name="lm_pers"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('lm_pers_selected').value != "") {
				var check_select = document.getElementById('lm_pers_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'dn':
			dati.set('campo', 'data_nascita');
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
		case 'dm':
			dati.set('campo', 'data_morte');
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
				} else {
					flagErrore = true;
				};
			} else {
				alert('Errore!');
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
			url: "php/modifica_campo_persona.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				window.location.assign("edit_persona.php?id=" + id);
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
var DBluoghi = [];
var DBinter = [];

// FUNZIONI PER L'AGGIUNTA DI NUOVE ENTITA' NEL DATABASE //////////////////////
function aggiornaDB(tipo) {
	if (tipo == 0) { // luogo
		DBluoghi = [];
		$.ajax({
			type: "POST",
			url: "php/trova_luoghi.php",
			success: function (resJ) {
				var res = JSON.parse(resJ);
				for (luogo of res) {
					DBluoghi.push(luogo);
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	} else if (tipo == 2) { // intervallo date
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

function return_back(tipoOgg, nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	if (tipoOgg == "ln") { // luogo nascita
		var nodoDiv = document.getElementById('pop_ln_pers');
		nodoDiv.innerHTML = "";
		aggiornaDB(0); // aggiornamento elenchi dei luoghi
		var luogoId = nodoDiv.id;
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<div class='dropdown'> \
							<input type='button' value='Scegli dall&#8217;elenco'> \
							<div id='ddc_ln_pers' class='dropdown_content'></div> \
							</div> \
							<div class='blank_space'></div> \
							<h2>Se non hai trovato quello che cerchi</h2> \
							<label for='ln_pers_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='ln_pers_list' id='ln_pers_search' name='ln_pers_search'> \
							<datalist id='ln_pers_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='luogo_search(\"ln\")'> \
							<input type='text' id='ln_pers_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Inserisci nuovo' onclick='apri_insert(\"ln\", this)'>";
		var radio_ln = "";
		var optio = "";
		var rlist_ln = document.getElementById('ddc_ln_pers');
		var dlist_ln = document.getElementById('ln_pers_list');
		rlist_ln.innerHTML = "";
		dlist_ln.innerHTML = "";
		for (var l = 0; l < DBluoghi.length; l++) {
			radio_ln = "<div><input type='radio' id='ln" + DBluoghi[l][0] + "' name='ln' value='" + DBluoghi[l][0] + "'> <label for='ln" + DBluoghi[l][0] + "'>" + DBluoghi[l][1] + "</label></div>";
			rlist_ln.insertAdjacentHTML('beforeend', radio_ln);
			optio = "<option data-id='" + DBluoghi[l][0] + "' value='" + DBluoghi[l][1] + "'>";
			dlist_ln.insertAdjacentHTML('beforeend', optio);
		};
	} else if (tipoOgg == "lm") { // luogo morte
		var nodoDiv = document.getElementById('pop_lm_pers');
		nodoDiv.innerHTML = "";
		aggiornaDB(0); // aggiornamento elenchi dei luoghi
		var luogoId = nodoDiv.id;
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<div class='dropdown'> \
							<input type='button' value='Scegli dall&#8217;elenco'> \
							<div id='ddc_lm_pers' class='dropdown_content'></div> \
							</div> \
							<div class='blank_space'></div> \
							<h2>Se non hai trovato quello che cerchi</h2> \
							<label for='lm_pers_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='lm_pers_list' id='lm_pers_search' name='lm_pers_search'> \
							<datalist id='lm_pers_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='luogo_search(\"lm\")'> \
							<input type='text' id='lm_pers_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Inserisci nuovo' onclick='apri_insert(\"lm\", this)'>";
		var radio_lm = "";
		var optio = "";
		var rlist_lm = document.getElementById('ddc_lm_pers');
		var dlist_lm = document.getElementById('lm_pers_list');
		rlist_lm.innerHTML = "";
		dlist_lm.innerHTML = "";
		for (var l = 0; l < DBluoghi.length; l++) {
			radio_lm = "<div><input type='radio' id='lm" + DBluoghi[l][0] + "' name='lm' value='" + DBluoghi[l][0] + "'> <label for='lm" + DBluoghi[l][0] + "'>" + DBluoghi[l][1] + "</label></div>";
			rlist_lm.insertAdjacentHTML('beforeend', radio_lm);
			optio = "<option data-id='" + DBluoghi[l][0] + "' value='" + DBluoghi[l][1] + "'>";
			dlist_lm.insertAdjacentHTML('beforeend', optio);
		};
	};
};

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

function apri_insert(tipo, nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<a href='#' onclick='return_back(\"" + tipo + "\", this)'>Torna alla scelta del luogo</a>";
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<p>Cerca il luogo prima su <a href='https://pleiades.stoa.org/' target='_blank' title='Inserisci in URI la \"canonical URI\", nelle coordinate quelle delle \"Representative Point\".'>Pleiades</a> poi su <a href='https://www.wikidata.org/wiki/Wikidata:Main_Page' target='_blank' title='Inserire le coordinate in formato decimale, visualizzabili cliccando sulle coordinate di Wikidata e aprendo la corrispondente pagina di GeoHack'>Wikidata</a> e copia le informazioni richieste.</p> \
						<form id='insert_luogo'> \
							<label for='nome'>Nome moderno:</label> \
							</br> \
							<input type='text' id='nome' maxlength='64'> \
							</br> \
							<label for='lat_" + tipo +"'>Latitudine:</label> \
							</br> \
							<input type='number' id='lat_" + tipo +"'  min='-90' max='90'> \
							</br> \
							<label for='lon_" + tipo +"'>Longitudine:</label> \
							</br> \
							<input type='number' id='lon_" + tipo +"'  min='-180' max='180'> \
							</br> \
							<label for='uri_" + tipo +"'>URI:</label> \
							</br> \
							<input type='url' id='uri_" + tipo +"' maxlength='256'> \
						</form> \
						</br> \
						<input type='button' id='insert_l' value='Inserisci luogo' onclick='insert_luog(this, \"" + tipo +"\")'> </br></br>\
						<p>Altrimenti, se non trovi il luoghi che cerchi:</p> \
						<input type='button' id='luogo_manuale' value='Scegli da mappa' onclick='luog_manuale(\"" + tipo + "\", this)'>";
};

// FUNZIONI SPECIFICHE PER I LUOGHI ///////////////////////////////////////////
function luogo_search(tipo) {
	var searchId = tipo + "_pers_search";
	var listId = tipo + "_pers_list";
	var selectId = tipo + "_pers_selected";
	var luogoS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var luogoId = document.querySelector("#" + listId + " option[value='" + luogoS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("Il luogo non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Luogo selezionato.");
		document.getElementById(selectId).value = luogoId;
		var tipoLuogo = tipo.concat(luogoId);
	};
};

function insert_luog(nodo, tipoL) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var res;
	var dati = new FormData();
	var nodoDiv = nodo.parentNode;
	var errori = new Array;
	var messaggio = "Inserisci correttamente: ";
	dati.append("nome", document.getElementById("nome").value);
	dati.append("lat", document.getElementById("lat_" + tipoL).value);
	dati.append("lon", document.getElementById("lon_" + tipoL).value);
	dati.append("uri", document.getElementById("uri_" + tipoL).value);
	
	if (dati.get("nome").length == 0) {
		errori.push("nome");
	};
	if (dati.get("lon").length == 0) {
		errori.push("longitudine");
	};
	if (dati.get("lat").length == 0) {
		errori.push("latitudine");
	};
	if (dati.get("uri").length == 0) {
		errori.push("URI");
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_luogo.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				return_back(tipoL, nodo);
				$.ajax({
					type: "POST",
					url: "php/trova_nuovoLuogo.php",
					data: dati,
					success: function (resJ) {
						res = JSON.parse(resJ);
						var luogoId = nodoDiv.id;
						var selectId = tipoL + "_tappa_selected";
						var searchId = tipoL + "_tappa_search";
						document.getElementById(selectId).value = res[0]; // id recuperato
						document.getElementById(searchId).value = res[1]; // nome recuperato
						alert("Luogo selezionato.");
					},
					processData: false,
					contentType: false,
					async: false
				});
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

function conf_punto(tipo, nodo) {
	var map = $('#map_' + tipo).data('map_' + tipo);
	var elencoLayer = map.getLayers().getArray();
	var layerNuovo = map.getLayers().item(1);
	var nuovoPunto = layerNuovo.getSource().getFeatures()[0].getGeometry();
	nuovoPunto.transform('EPSG:3857', 'EPSG:4326');
	coordinate = nuovoPunto.getCoordinates();
	document.getElementById('lon_' + tipo).value = coordinate[0];
	document.getElementById('lat_' + tipo).value = coordinate[1];
	for (var l = 1; l < elencoLayer.length; l++) { // salta il raster openlayers
		map.removeLayer(elencoLayer[l]); 
	};
	nodo.value = 'Scegli dalla mappa';
	nodo.setAttribute('onclick', 'selez_da_mappa("' + tipo + '", this)');
};

function selez_da_mappa(tipoLuog, nodo) {
	var map = $('#map_' + tipoLuog).data('map_' + tipoLuog);
	// stili
	var rigaCrea = new ol.style.Stroke({ color: 'blue', width: 2	});
	var riempimentoCrea = new ol.style.Fill({ color: 'rgba(0,0,255,0.5)' });
	var stileCrea = new ol.style.Style({
		image: new ol.style.Circle({
			fill: riempimentoCrea,
			stroke: rigaCrea,
			radius: 4
		}),
		fill: riempimentoCrea,
		stroke: rigaCrea
	});
	var rigaNuova = new ol.style.Stroke({ color: 'green', width: 2	});
	var riempimentoNuovo = new ol.style.Fill({ color: 'rgba(0,255,0,0.5)' });
	var stileNuovo = new ol.style.Style({
		image: new ol.style.Circle({
			fill: riempimentoNuovo,
			stroke: rigaNuova,
			radius: 4
		}),
		fill: riempimentoNuovo,
		stroke: rigaNuova
	});
	// layer
	var vettoreNuovo = new ol.source.Vector({});
	var layerNuovo = new ol.layer.Vector({
		source: vettoreNuovo,
		style: stileNuovo
	});
	// interazione
	var evtNuovo = new ol.interaction.Draw({
		type: 'Point',
		style: stileCrea
	});
	evtNuovo.on('drawend', function(evt) {
		vettoreNuovo.addFeature(evt.feature);
		alert('Punto selezionato');
		map.getInteractions().pop();
		nodo.value = 'Conferma punto';
		nodo.setAttribute('onclick', 'conf_punto("' + tipoLuog + '", this)');
	});
	map.addLayer(layerNuovo);
	map.getInteractions().pop();
	map.addInteraction(evtNuovo);
};

function luog_manuale(tipoLuogo, nodo) {
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<a href='#' onclick='return_back(\"" + tipoLuogo +"\", this)'>Torna alla scelta del luogo</a>";
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<form id='insert_luogo'> \
							<label for='nome'>Nome moderno:</label> \
							</br> \
							<input type='text' id='nome' maxlength='64'> \
							</br> \
							<label for='lat_" + tipoLuogo +"'>Latitudine:</label> \
							</br> \
							<input type='number' id='lat_" + tipoLuogo +"'  min='-90' max='90'> \
							</br> \
							<label for='lon_" + tipoLuogo +"'>Longitudine:</label> \
							</br> \
							<input type='number' id='lon_" + tipoLuogo +"'  min='-180' max='180'> \
							</br> \
							<input id='uri_" + tipoLuogo +"' value='Inserito manualmente' hidden='hidden'> \
						</form> \
						</br> \
						<input type='button' id='insert_l' value='Inserisci luogo' onclick='insert_luog(this, \"" + tipoLuogo +"\")'> \
						</br> \
						<input type='button' id='selezione_mappa' value='Scegli dalla mappa' onclick='selez_da_mappa(\"" + tipoLuogo + "\", this)'> \
						</br> \
						<div id='map_" + tipoLuogo + "' class=map></div>";
	// mappa
	var map = new ol.Map({
		target: 'map_' + tipoLuogo,
		layers: [
			new ol.layer.Tile({
				source: new ol.source.OSM({url: 'http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png'})
			}),
		],
		view: new ol.View({
			center: ol.proj.fromLonLat([8.6, 46.71]), //Wassen
			zoom: 5
		})
	});
	$('#map_' + tipoLuogo).data('map_' + tipoLuogo, map);
};
