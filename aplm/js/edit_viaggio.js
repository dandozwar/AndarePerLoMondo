// FUNZIONI GESTIONE DI UNA TAPPA /////////////////////////////////////////////
function modifica_tappa(idTappa) {
	window.location.assign('edit_tappa.php?id=' + idTappa + '');
};

function elimina_tappa(idTappa, idViaggio, posizione) {
	if (confirm('Eliminare definitivamente questa tappa?')) {
		var user = new URLSearchParams(window.location.search).get('user');
		$.ajax({
			type: 'POST',
			url: 'php/delete_tappa.php',
			data: {'id': idTappa, 'viaggio': idViaggio, 'pos': posizione},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Tappa eliminata.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_tappa(idViaggio) {
	var res;
	var id_nuovo;
	var user = new URLSearchParams(window.location.search).get('user');
	$.ajax({
		type: 'POST',
		url: 'php/insert_tappa.php',
		data: {'viaggio': idViaggio},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) { 
				id_nuovo = res[0];
				modifica_tappa(id_nuovo);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

// FUNZIONI GESTIONE DI UN PARTECIPANTE ///////////////////////////////////////
function elimina_partecipante(idParte, idViaggio) {
	if (confirm('Eliminare questa persona dalla lista dei partecipanti?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_partecipante.php',
			data: {'tipo': 'viaggio', 'partecipante': idParte, 'id': idViaggio},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Partecipante eliminato.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_partecipante(idViaggio) {
	window.location.assign('insert_partecipante.php?tipo=v&id=' + idViaggio + '');
};

// FUNZIONI GESTIONE DI UN MOTIVO /////////////////////////////////////////////
function elimina_motivo(idScopo, idViaggio) {
	if (confirm('Eliminare questa scopo fra quelli dal viaggio?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_motivo.php',
			data: {tipo: 'viaggio', 'scopo': idScopo, 'id': idTappa},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Motivo viaggio eliminato.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_motivo(idViaggio) {
	window.location.assign('insert_motivo.php?tipo=v&id=' + idViaggio + '');
};

// FUNZIONI MODIFICA DI UN CAMPO DEL VIAGGIO //////////////////////////////////
function modifica_campo(id, campo) {
	window.location.assign("edit_viaggio.php?id=" + id + "&campo=" + campo);
};

function invia_campo(id, campo, versione = null) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	switch (campo) {
		case 'ti':
			dati.append('campo', 'titolo');
			var titolo = document.getElementById('ti').value;
			if (titolo != "") {
				dati.append('valore', titolo);
			} else {
				flagErrore = true;
			};
			break;
		case 'lp':
			dati.append('campo', 'luogo_partenza');
			if (document.querySelector('input[name="lp_viaggio"]:checked')) {
				var check_radio = document.querySelector('input[name="lp_viaggio"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('lp_viaggio_selected').value != "") {
				var check_select = document.getElementById('lp_viaggio_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'lm':
			dati.append('campo', 'luogo_meta');
			if (document.querySelector('input[name="lm_viaggio"]:checked')) {
				var check_radio = document.querySelector('input[name="lm_viaggio"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('lm_viaggio_selected').value != "") {
				var check_select = document.getElementById('lm_viaggio_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'dp':
			dati.set('campo', 'data_partenza');
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
					document.getElementById('ins_anno').value > '1492-10-12') {
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
		case 'pi':
			dati.append('campo', 'piano');
			var piano = document.getElementById('pi').value;
			if (piano != "") {
				dati.append('valore', piano);
			} else {
				flagErrore = true;
			};
			break;
		case 'fo':
			dati.append('campo', 'fonte');
			if (document.querySelector('input[name="fonte"]:checked')) {
				var check_radio = document.querySelector('input[name="fonte"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('fonte_selected').value != "") {
				var check_select = document.getElementById('fonte_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			if (document.getElementById('pag_viaggio').value != "") {
				var pagine = document.getElementById('pag_viaggio').value;
				dati.set('pagine', pagine);
			} else {
				dati.set('pagine', '');
			};
			break;
		case 'pu':
			dati.append('campo', 'pubblico');
			if (document.querySelector('input[name="pubblico"]:checked')) {
				var check_radio = document.querySelector('input[name="pubblico"]:checked').value;
				dati.set('valore', check_radio);
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
			url: "php/modifica_campo_viaggio.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ != 'Titolo già presente.') {
					//$(window).unbind('beforeunload');
					window.location.assign("edit_viaggio.php?id=" + id);
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
var DBluoghi = [];
var DBfontiTue = [];
var DBfontiAlt = [];
var DBinter = [];

// FUNZIONI PER L'AGGIUNTA DI NUOVE ENTITA' NEL DATABASE //////////////////////
function aggiornaDB(tipo, utente = null) {
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
	} else if (tipo == 1) { // fonte dell'utente
		var dati = new FormData();
		dati.set('utente', utente)
		DBfontiTue = [];
		$.ajax({
			type: "POST",
			data: dati,
			url: "php/trova_fonti_utente.php",
			success: function (resJ) {
				var res = JSON.parse(resJ);
				for (fonte of res) {
					DBfontiTue.push(fonte);
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
	} else if (tipo == 3) { // fonti altrui
		DBfontiAlt = [];
		var dati = new FormData();
		dati.set('utente', utente)
		$.ajax({
			type: "POST",
			url: "php/trova_fonti_altrui.php",
			data: dati,
			success: function (resJ) {
				var res = JSON.parse(resJ);
				for (fonte of res) {
					DBfontiAlt.push(fonte);
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	};
};

function return_back(tipoOgg, nodo, nickUtente = null) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	if (tipoOgg == "lp") { // luogo partenza
		var nodoDiv = document.getElementById('pop_lp_viaggio');
		nodoDiv.innerHTML = "";
		aggiornaDB(0); // aggiornamento elenchi dei luoghi
		var luogoId = nodoDiv.id;
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<div class='dropdown'> \
							<input type='button' value='Scegli dall&#8217;elenco'> \
							<div id='ddc_lp_viaggio' class='dropdown_content'></div> \
							</div> \
							<div class='blank_space'></div> \
							<h2>Se non hai trovato quello che cerchi</h2> \
							<label for='lp_viaggio_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='lp_viaggio_list' id='lp_viaggio_search' name='lp_viaggio_search'> \
							<datalist id='lp_viaggio_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='luogo_search(\"lp\")'> \
							<input type='text' id='lp_viaggio_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Inserisci nuovo' onclick='apri_insert(\"lp\", this)'>";
		var radio_lp = "";
		var optio = "";
		var rlist_lp = document.getElementById('ddc_lp_viaggio');
		var dlist_lp = document.getElementById('lp_viaggio_list');
		rlist_lp.innerHTML = "";
		dlist_lp.innerHTML = "";
		for (var l = 0; l < DBluoghi.length; l++) {
			radio_lp = "<div><input type='radio' id='lp" + DBluoghi[l][0] + "' name='lp' value='" + DBluoghi[l][0] + "'> <label for='lp" + DBluoghi[l][0] + "'>" + DBluoghi[l][1] + "</label></div>";
			rlist_lp.insertAdjacentHTML('beforeend', radio_lp);
			optio = "<option data-id='" + DBluoghi[l][0] + "' value='" + DBluoghi[l][1] + "'>";
			dlist_lp.insertAdjacentHTML('beforeend', optio);
		};
	} else if (tipoOgg == "lm") { // luogo meta
		var nodoDiv = document.getElementById('pop_lm_viaggio');
		nodoDiv.innerHTML = "";
		aggiornaDB(0); // aggiornamento elenchi dei luoghi
		var luogoId = nodoDiv.id;
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<div class='dropdown'> \
							<input type='button' value='Scegli dall&#8217;elenco'> \
							<div id='ddc_lm_viaggio' class='dropdown_content'></div> \
							</div> \
							<div class='blank_space'></div> \
							<h2>Se non hai trovato quello che cerchi</h2> \
							<label for='lm_viaggio_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='lm_viaggio_list' id='lm_viaggio_search' name='lm_viaggio_search'> \
							<datalist id='lm_viaggio_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='luogo_search(\"lm\")'> \
							<input type='text' id='lm_viaggio_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Inserisci nuovo' onclick='apri_insert(\"lm\", this)'>";
		var radio_lm = "";
		var optio = "";
		var rlist_lm = document.getElementById('ddc_lm_viaggio');
		var dlist_lm = document.getElementById('lm_viaggio_list');
		rlist_lm.innerHTML = "";
		dlist_lm.innerHTML = "";
		for (var l = 0; l < DBluoghi.length; l++) {
			radio_lm = "<div><input type='radio' id='lm" + DBluoghi[l][0] + "' name='lm' value='" + DBluoghi[l][0] + "'> <label for='lm" + DBluoghi[l][0] + "'>" + DBluoghi[l][1] + "</label></div>";
			rlist_lm.insertAdjacentHTML('beforeend', radio_lm);
			optio = "<option data-id='" + DBluoghi[l][0] + "' value='" + DBluoghi[l][1] + "'>";
			dlist_lm.insertAdjacentHTML('beforeend', optio);
		};
	} else if (tipoOgg == "fo") { // fonte
		var nodoDiv = document.getElementById('pop_fonte');
		nodoDiv.innerHTML = "";
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<div class='dropdown'> \
								<input type='button' value='Scegli dall&#8217;elenco'><br/> \
								<div id='ddc_fonte' class='dropdown_content'></div> \
							</div> \
							<div class='blank_space'></div> \
							<h2>Se non hai trovato quello che cerchi</h2> \
							<label for='fonte_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='fonte_list' id='fonte_search' name='fonte_search'> \
							<datalist id='fonte_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='fonti_search()'> \
							<input type='text' id='fonte_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Inserisci nuova' onclick='apri_insert(\"f\", this, \"" + nickUtente +"\")'><input type='button' value='Copia esistente' onclick='copia_fonte(this, \"" + nickUtente +"\")'><br/> \
							<label for='pag_viaggio'>Pagine specifiche:</label><br/> \
							<input type='text' id='pag_viaggio' maxlength='32'>";
		aggiornaDB(1, nickUtente); // aggiornamento elenco delle fonti tue
		var radio = "";
		var optio = "";
		var rlist = document.getElementById('ddc_fonte');
		var dlist = document.getElementById('fonte_list');
		rlist.innerHTML = "";
		dlist.innerHTML = "";
		for (var f = 0; f < DBfontiTue.length; f++) {
			radio = "<div><input type='radio' id='f" + DBfontiTue[f][0] + "' name='fonte' value='" + DBfontiTue[f][0] + "'> <label for='f" + DBfontiTue[f][0] + "'>" + DBfontiTue[f][1] + "</label></div>";
			rlist.insertAdjacentHTML('beforeend', radio);

			optio = "<option data-id='" + DBfontiTue[f][0] + "' value='" + DBfontiTue[f][1] + "'>";
			dlist.insertAdjacentHTML('beforeend', optio);
		};
	};
};

function scegli_tipo(versione, tipoOgg, nickUtente) {
	if (tipoOgg == "fo") {
		var nodo_campi = document.getElementById('campi_fonte');
		nodo_campi.innerHTML = "";
		switch(versione) {
			case 'mono':
				nodo_campi.innerHTML = '<form id="form_fonte"> \
											<h2>Monografia o tomo in collana</h2> \
											<table> \
												<tr><th>Autore:</th><td><input type="text" id="autore" name="autore" maxlength="128"/></td></tr> \
												<tr><th>Titolo:</th><td><input type="text" id="titolo" name="titolo" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Curatore:</th><td><input type="text" id="curatore" name="curatore" maxlength="128"/></td></tr> \
												<tr><th>Luogo:</th><td><input type="text" id="luogo" name="luogo" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Editore:</th><td><input type="text" id="editore" name="editore" maxlength="128"/></td></tr> \
												<tr><th>Anno:</th><td><input type="text" id="anno" name="anno" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Collana:</th><td><input type="text" id="collana" name="collana" maxlength="128"/></td></tr> \
											</table> \
											<p>Con * sono segnati i campi obbligatori.</p> \
										</form> \
										<input id="insert_f" type="button" value="Inserisci fonte" onclick="insert_font(\'mono\', \'' + nickUtente +'\')"/>';
				break;
			case 'art_vol':
				nodo_campi.innerHTML = '<form id="form_fonte"> \
											<h2>Articolo in volume</h2> \
											<table> \
												<tr><th>Autore:</th><td><input type="text" id="autore" name="autore" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Titolo:</th><td><input type="text" id="titolo" name="titolo" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Titolo volume:</th><td><input type="text" id="titolo_volume" name="titolo_volume" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Curatore:</th><td><input type="text" id="curatore" name="curatore" maxlength="128"/></td></tr> \
												<tr><th>Luogo:</th><td><input type="text" id="luogo" name="luogo" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Editore:</th><td><input type="text" id="editore" name="editore" maxlength="128"/></td></tr> \
												<tr><th>Anno:</th><td><input type="text" id="anno" name="anno" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Collana:</th><td><input type="text" id="collana" name="collana" maxlength="128"/></td></tr> \
												<tr><th>Pagine:</th><td><input type="text" id="pagine" name="pagine" maxlength="128"/></td><td>*</td></tr> \
											</table> \
											<p>Con * sono segnati i campi obbligatori.</p> \
										</form> \
										<input id="insert_f" type="button" value="Inserisci fonte" onclick="insert_font(\'art_vol\', \'' + nickUtente +'\')"/>';
				break;
			case 'art_riv':
				nodo_campi.innerHTML = '<form id="form_fonte"> \
											<h2>Articolo in rivista</h2> \
											<table> \
												<tr><th>Autore:</th><td><input type="text" id="autore" name="autore" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Titolo:</th><td><input type="text" id="titolo" name="titolo" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Titolo rivista:</th><td><input type="text" id="titolo_rivista" name="titolo_rivista" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Numero:</th><td><input type="text" id="numero" name="numero" maxlength="128"/></td></tr> \
												<tr><th>Anno:</th><td><input type="text" id="anno" name="anno" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Pagine:</th><td><input type="text" id="pagine" name="pagine" maxlength="128"/></td><td>*</td></tr> \
											</table> \
											<p>Con * sono segnati i campi obbligatori.</p> \
										</form> \
										<input id="insert_f" type="button" value="Inserisci fonte" onclick="insert_font(\'art_riv\', \'' + nickUtente +'\')"/>';
				break;
			case 'web':
				nodo_campi.innerHTML = '<form id="form_fonte"> \
											<h2>Pagina web</h2> \
											<table> \
												<tr><th>Autore:</th><td><input type="text" id="autore" name="autore" maxlength="128"/></td></tr> \
												<tr><th>Titolo:</th><td><input type="text" id="titolo" name="titolo" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Nome sito:</th><td><input type="text" id="nome_sito" name="nome_sito" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>Anno:</th><td><input type="text" id="anno" name="anno" maxlength="128"/></td><td>*</td></tr> \
												<tr><th>URL:</th><td><input type="text" id="url" name="url" maxlength="128"/></td><td>*</td></tr> \
											</table> \
											<p>Con * sono segnati i campi obbligatori.</p> \
										</form> \
										<input id="insert_f" type="button" value="Inserisci fonte" onclick="insert_font(\'web\', \'' + nickUtente +'\')"/>';
				break;
			case 'altro':
				nodo_campi.innerHTML = '<form id="form_fonte"> \
											<h2>Altro</h2> \
											<table> \
												<tr><th>Autore:</th><td><input type="text" id="autore" name="autore" maxlength="128"/></td></tr> \
												<tr><th>Titolo:</th><td><input type="text" id="titolo" name="titolo" maxlength="128"/></td></tr> \
												<tr><th>Titolo volume:</th><td><input type="text" id="titolo_volume" name="titolo_volume" maxlength="128"/></td></tr> \
												<tr><th>Titolo rivista:</th><td><input type="text" id="titolo_rivista" name="titolo_rivista" maxlength="128"/></td></tr> \
												<tr><th>Numero:</th><td><input type="text" id="numero" name="numero" maxlength="128"/></td></tr> \
												<tr><th>Pagine:</th><td><input type="text" id="pagine" name="pagine" maxlength="128"/></td></tr> \
												<tr><th>Curatore:</th><td><input type="text" id="curatore" name="curatore" maxlength="128"/></td></tr> \
												<tr><th>Luogo:</th><td><input type="text" id="luogo" name="luogo" maxlength="128"/></td></tr> \
												<tr><th>Editore:</th><td><input type="text" id="editore" name="editore" maxlength="128"/></td></tr> \
												<tr><th>Anno:</th><td><input type="text" id="anno" name="anno" maxlength="128"/></td></tr> \
												<tr><th>Collana:</th><td><input type="text" id="collana" name="collana" maxlength="128"/></td></tr> \
												<tr><th>Nome sito:</th><td><input type="text" id="nome_sito" name="nome_sito" maxlength="128"/></td></tr> \
												<tr><th>URL:</th><td><input type="text" id="url" name="url" maxlength="128"/></td></tr> \
											</table> \
										</form> \
										<input id="insert_f" type="button" value="Inserisci fonte" onclick="insert_font(\'altro\', \'' + nickUtente +'\')"/>';
				break;
			default:
				alert('Errore!');
				break;
		};
	} else if (tipoOgg == "dp" || tipoOgg == "df") {
		var nodo_campi = document.getElementById('campi_data');
		var nodo_invia = document.getElementById('invia');
		var viaggio = new URLSearchParams(window.location.search).get('id');
		nodo_campi.innerHTML = "";
		switch (versione) {
			case "anno":
				nodo_campi.innerHTML = '<form id="form_data"> \
											<h2>Solo anno</h2> \
											<p>Anni compresi fra il 476 e il 1492.</p>\
											<input type="number" id="ins_anno" name="ins_anno" min="476" max="1492"/> \
										</form>';
				nodo_invia.setAttribute('onclick', 'invia_campo(' + viaggio + ', \'' + tipoOgg +'\', \'anno\')');
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
				nodo_invia.setAttribute('onclick', 'invia_campo(' + viaggio + ', \'' + tipoOgg +'\', \'anno_mese\')');
				break;
			case "data":
				nodo_campi.innerHTML = '<form id="form_data"> \
											<h2>Data completa</h2> \
											<p>Anni compresi fra il 476 e il 1492.</p>\
											<input type="date" id="ins_data" name="ins_data"/>\
										</form>';
				nodo_invia.setAttribute('onclick', 'invia_campo(' + viaggio + ', \'' + tipoOgg +'\', \'data\')');
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
				nodo_invia.setAttribute('onclick', 'invia_campo(' + viaggio + ', \'' + tipoOgg +'\', \'intervallo\')');
				break;
			default:
				alert('Errore!');
				break;
		};
	};
};

function apri_insert(tipo, nodo, nick = null) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	if (tipo == 'lp' || tipo == 'lm') { // luogo
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
							<input type='button' id='luogo_manuale' value='Scegli da mappa' onclick='luog_manuale(\"" + tipo + "\", this)'>"
	} else if (tipo == 'f') { // fonte
		nodoDiv.innerHTML = "<a href='#' onclick='return_back(\"fo\", this, \"" + nick +"\")'>Torna alla scelta della fonte</a><br/>";
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<label for='tipo'>Tipo di fonte:</label><br/> \
							<div class='dropdown'> \
								<input type='button' id='tipo' value='Scegli dall&#8217;elenco' onclick='pop_hover(this)'/> \
								<div class='dropdown_content'> \
									<div><input type='radio' id='mono' name='tipo' value='mono' onclick='scegli_tipo(this.id, \"fo\", \"" + nick +"\")' <label for='mono'>Monografia o tomo in collana</label></div> \
									<div><input type='radio' id='art_vol' name='tipo' value='art_vol' onclick='scegli_tipo(this.id, \"fo\", \"" + nick +"\")' <label for='art_vol'>Articolo in volume</label></div> \
									<div><input type='radio' id='art_riv' name='tipo' value='art_riv' onclick='scegli_tipo(this.id, \"fo\", \"" + nick +"\")' <label for='art_riv'>Articolo in rivista</label></div> \
									<div><input type='radio' id='web' name='tipo' value='web' onclick='scegli_tipo(this.id, \"fo\", \"" + nick +"\")' <label for='web'>Pagina web</label></div> \
									<div><input type='radio' id='altro' name='tipo' value='altro' onclick='scegli_tipo(this.id, \"fo\", \"" + nick +"\")' <label for='mono'>Altro</label></div> \
								</div> \
							</div>\
							<div class='blank_space'></div> \
							<div id='campi_fonte'> \
							</div>";
	};
};

// FUNZIONI SPECIFICHE PER I LUOGHI ///////////////////////////////////////////
function luogo_search(tipo) {
	var searchId = tipo + "_viaggio_search";
	var listId = tipo + "_viaggio_list";
	var selectId = tipo + "_viaggio_selected";
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
						var selectId = tipoL + "_viaggio_selected";
						var searchId = tipoL + "_viaggio_search";
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

// FUNZIONI SPECIFICHE PER LE FONTI ///////////////////////////////////////////
function fonti_search() {
	var searchId = "fonte_search";
	var listId = "fonte_list";
	var selectId = "fonte_selected";
	var fonteS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var fonteId = document.querySelector("#" + listId + " option[value='" + fonteS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("La fonte non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Fonte selezionata.");
		document.getElementById(selectId).value = fonteId;
	};
};


function insert_font(tipoFonte, nickUser) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var res;
	var form = document.getElementById('form_fonte');
	var dati = new FormData(form);
	dati.set('utente', nickUser);
	var errori = new Array;
	var messaggio = "Inserisci ";
	switch (tipoFonte) {
		case 'mono':
			if (dati.get("titolo").length == 0) {
				errori.push("titolo");
			};
			if (dati.get("luogo").length == 0) {
				errori.push("luogo");
			};
			if (dati.get("anno").length == 0) {
				errori.push("anno");
			};
			break;
		case 'art_vol':
			if (dati.get("autore").length == 0) {
				errori.push("autore");
			};
			if (dati.get("titolo").length == 0) {
				errori.push("titolo");
			};
			if (dati.get("titolo_volume").length == 0) {
				errori.push("titolo_volume");
			};
			if (dati.get("luogo").length == 0) {
				errori.push("luogo");
			};
			if (dati.get("anno").length == 0) {
				errori.push("anno");
			};
			if (dati.get("pagine").length == 0) {
				errori.push("pagine");
			};
			break;
		case 'art_riv':
			if (dati.get("autore").length == 0) {
				errori.push("autore");
			};
			if (dati.get("titolo").length == 0) {
				errori.push("titolo");
			};
			if (dati.get("titolo_rivista").length == 0) {
				errori.push("titolo_rivista");
			};
			if (dati.get("anno").length == 0) {
				errori.push("anno");
			};
			if (dati.get("pagine").length == 0) {
				errori.push("pagine");
			};
			break;
		case 'web':
			if (dati.get("titolo").length == 0) {
				errori.push("titolo");
			};
			if (dati.get("nome_sito").length == 0) {
				errori.push("nome_sito");
			};
			if (dati.get("anno").length == 0) {
				errori.push("anno");
			};
			if (dati.get("url").length == 0) {
				errori.push("url");
			};
			break;
		case 'altro': break;
		default: alert('Errore!'); break;
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_fonte.php",
			data: dati,
			success: function (resJ) {
				return_back("fo", nickUser);
				res = JSON.parse(resJ);
				var selectId = "fonte_selected";
				var searchId = "fonte_search";
				document.getElementById(selectId).value = res[0]; // id recuperato
				document.getElementById(searchId).value = res[1]; // cit_biblio recuperata
				alert("Fonte selezionata.");
			},
			processData: false,
			contentType: false,
			async: false
		});
	} else {
		messaggio = messaggio + " " + errori[0] + ".";
		alert(messaggio);
	};
};

function copia_dati(nodo) {
	var fonteS = nodo.value;
	var dati = new FormData();
	dati.set('id', fonteS);
	$.ajax({
		type: "POST",
		data: dati,
		url: "php/trova_fonte_selezionata.php",
		success: function (resJ) {
			var res = JSON.parse(resJ);
			document.getElementsByName('autore')[0].value = res[1];
			document.getElementsByName('titolo')[0].value = res[2];
			document.getElementsByName('titolo_volume')[0].value = res[3];
			document.getElementsByName('titolo_rivista')[0].value = res[4];
			document.getElementsByName('numero')[0].value = res[5];
			document.getElementsByName('curatore')[0].value = res[6];
			document.getElementsByName('luogo')[0].value = res[7];
			document.getElementsByName('editore')[0].value = res[8];
			document.getElementsByName('nome_sito')[0].value = res[9];
			document.getElementsByName('anno')[0].value = res[10];
			document.getElementsByName('collana')[0].value = res[11];
			document.getElementsByName('pagine')[0].value = res[12];
			document.getElementsByName('url')[0].value = res[13];
		},
		processData: false,
		contentType: false,
		async: false
	});
};

function copia_fonte(nodo, utente) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<a href='#' onclick='return_back(\"fo\", this, \"" + utente +"\")'>Torna alla scelta della fonte</a><br/>";
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<p>Seleziona come fonte di partenza una dall'elenco.</p> \
						<div class='dropdown'> \
							<input type='button' value='Scegli dall&#8217;elenco'><br/> \
							<div id='ddc_fonte' class='dropdown_content'></div> \
						</div> \
						<div class='blank_space'></div> \
						</br> \
						</br> \
						<form id='form_fonte'> \
							<h2>Altro</h2> \
							<table> \
								<tr><th>Autore:</th><td><input type='text' id='autore' name='autore' maxlength='128'/></td></tr> \
								<tr><th>Titolo:</th><td><input type='text' id='titolo' name='titolo' maxlength='128'/></td></tr> \
								<tr><th>Titolo volume:</th><td><input type='text' id='titolo_volume' name='titolo_volume' maxlength='128'/></td></tr> \
								<tr><th>Titolo rivista:</th><td><input type='text' id='titolo_rivista' name='titolo_rivista' maxlength='128'/></td></tr> \
								<tr><th>Numero:</th><td><input type='text' id='numero' name='numero' maxlength='128'/></td></tr> \
								<tr><th>Pagine:</th><td><input type='text' id='pagine' name='pagine' maxlength='128'/></td></tr> \
								<tr><th>Curatore:</th><td><input type='text' id='curatore' name='curatore' maxlength='128'/></td></tr> \
								<tr><th>Luogo:</th><td><input type='text' id='luogo' name='luogo' maxlength='128'/></td></tr> \
								<tr><th>Editore:</th><td><input type='text' id='editore' name='editore' maxlength='128'/></td></tr> \
								<tr><th>Anno:</th><td><input type='text' id='anno' name='anno' maxlength='128'/></td></tr> \
								<tr><th>Collana:</th><td><input type='text' id='collana' name='collana' maxlength='128'/></td></tr> \
								<tr><th>Nome sito:</th><td><input type='text' id='nome_sito' name='nome_sito' maxlength='128'/></td></tr> \
								<tr><th>URL:</th><td><input type='text' id='url' name='url' maxlength='128'/></td></tr> \
							</table> \
						</form> \
						<input id='insert_f' type='button' value='Inserisci fonte' onclick='insert_font(\"altro\", \"" + utente + "\")'/>";
	aggiornaDB(3, utente); // aggiornamento elenco delle fonti altrui
	var radio = "";
	var rlist = document.getElementById('ddc_fonte');
	rlist.innerHTML = "";
	for (var f = 0; f < DBfontiAlt.length; f++) {
		radio = "<div><input type='radio' id='f" + DBfontiAlt[f][0] + "' name='fonte' value='" + DBfontiAlt[f][0] + "' onclick='copia_dati(this)'> <label for='f" + DBfontiAlt[f][0] + "'>" + DBfontiAlt[f][1] + "</label></div>";
		rlist.insertAdjacentHTML('beforeend', radio);
	};
};
