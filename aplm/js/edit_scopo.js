// FUNZIONI GESTIONE DI UN DESTINATARIO ///////////////////////////////////////
function elimina_destinatario(idDesti, idScopo) {
	if (confirm('Eliminare questa persona dalla lista dei destinatari?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_destinatario.php',
			data: {'destinatario': idDesti, 'id': idScopo},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Destinatario eliminato.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_destinatario(idScopo) {
	window.location.assign('insert_destinatario.php?id=' + idScopo + '');
};

// FUNZIONI GESTIONE DI UN MANDATE ////////////////////////////////////////////
function elimina_mandante(idManda, idScopo) {
	if (confirm('Eliminare questa persona dalla lista dei mandanti?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_mandante.php',
			data: {'mandante': idManda, 'id': idScopo},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Mandante eliminato.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_mandante(idScopo) {
	window.location.assign('insert_mandante.php?id=' + idScopo + '');
};

// FUNZIONI MODIFICA DI UN CAMPO DEL VIAGGIO //////////////////////////////////
function modifica_campo(id, campo) {
	window.location.assign("edit_scopo.php?id=" + id + "&campo=" + campo);
};

function invia_campo(id, campo) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	switch (campo) {
		case 'ti':
			dati.append('campo', 'tipo');
			if (document.querySelector('input[name="tipo_scopo"]:checked')) {
				var check_radio = document.querySelector('input[name="tipo_scopo"]:checked').value;
				dati.set('valore', check_radio);
			} else if (document.getElementById('tipo_scopo_selected').value != "") {
				var check_select = document.getElementById('tipo_scopo_selected').value;
				dati.set('valore', check_select);
			} else {
				flagErrore = true;
			};
			break;
		case 'su':
			dati.append('campo', 'successo');
			if (document.querySelector('input[name="successo"]:checked')) {
				var check_radio = document.querySelector('input[name="successo"]:checked').value;
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
			url: "php/modifica_campo_scopo.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Modifica effettuata.') {
					//$(window).unbind('beforeunload');
					window.location.assign("edit_scopo.php?id=" + id);
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
var DBtiposcop = [];

// FUNZIONI SPECIFICHE PER GLI SCOPI //////////////////////////////////////////
function aggiornaDB(tipo) {
	DBtiposcop = [];
	$.ajax({
		type: "POST",
		url: "php/trova_tipi_scopi.php",
		success: function (resJ) {
			var res = JSON.parse(resJ);
			for (scopo of res) {
				DBtiposcop.push(scopo);
			};
		},
		processData: false,
		contentType: false,
		async: false
	});
};

function return_back(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var nodoDiv = document.getElementById('pop_tipo_scopo');
	nodoDiv.innerHTML = "";
	aggiornaDB(0); // aggiornamento elenchi dei tipi scopo
	var luogoId = nodoDiv.id;
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<div class='dropdown'> \
						<input type='button' value='Scegli dall&#8217;elenco'> \
						<div id='ddc_tipo_scopo' class='dropdown_content'></div> \
						</div> \
						<div class='blank_space'></div> \
						<h3>Se non hai trovato quello che cerchi</h3> \
						<label for='tipo_scopo_search'>Cerca nel database:</label> \
						</br> \
						<input type='text' list='tipo_scopo_list' id='tipo_scopo_search' name='tipo_scopo_search'> \
						<datalist id='tipo_scopo_list'> \
						</datalist> \
						</br> \
						<input type='button' value='Seleziona' onclick='tipo_search()'> \
						<input type='text' id='tipo_scopo_selected' hidden='hidden'> \
						</br> \
						</br> \
						<input type='button' value='Inserisci nuovo' onclick='apri_insert(this)'>";
	var radio_tisc = "";
	var optio = "";
	var rlist_tisc = document.getElementById('ddc_tipo_scopo');
	var dlist_tisc = document.getElementById('tipo_scopo_list');
	rlist_tisc.innerHTML = "";
	dlist_tisc.innerHTML = "";
	for (var t = 0; t < DBtiposcop.length; t++) {
		radio_tisc = "<div><input type='radio' id='tisc" + DBtiposcop[t][0] + "' name='tipo_scopo' value='" + DBtiposcop[t][0] + "'> <label for='tisc" + DBtiposcop[t][0] + "'>" + DBtiposcop[t][1] + "</label></div>";
		rlist_tisc.insertAdjacentHTML('beforeend', radio_tisc);
		optio = "<option data-id='" + DBtiposcop[t][0] + "' value='" + DBtiposcop[t][1] + "'>";
		dlist_tisc.insertAdjacentHTML('beforeend', optio);
	};
};

function apri_insert(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<a href='#' onclick='return_back(this)'>Torna alla scelta del luogo</a>";
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<p>Inserire lo scopo.<br/>Deve essere una stringa che inzia con un verbo al tempo infinito e lettera minuscola,<br/>terminante per la preposizione che la collega al complemento oggetto che sono i destinatari (se li ammette).</p> \
						<form id='insert_tipo'> \
							<label for='tipo'>Tipo:</label> \
							</br> \
							<input type='text' id='tipo' maxlength='64'> \
							</br> \
						</form> \
						</br> \
						<input type='button' id='insert_ts' value='Inserisci scopo' onclick='insert_tipo(this)'> </br></br>";
};

function tipo_search() {
	var searchId = "tipo_scopo_search";
	var listId = "tipo_scopo_list";
	var selectId = "tipo_scopo_selected";
	var scopoS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var scopoId = document.querySelector("#" + listId + " option[value='" + scopoS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("Lo scopo non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Scopo selezionato.");
		document.getElementById(selectId).value = scopoId;
	};
};

function insert_tipo(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var res;
	var dati = new FormData();
	var nodoDiv = nodo.parentNode;
	var errori = new Array;
	var messaggio = "Inserisci correttamente: ";
	dati.set("tipo", document.getElementById("tipo").value);
	
	if (dati.get("tipo").length == 0) {
		errori.push("tipo");
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_tipo_scopo.php",
			data: dati,
			success: function (resJ) {
				if (resJ != 'Scopo già inserito.') {
					return_back(nodo);
					res = JSON.parse(resJ);
					var selectId = "tipo_scopo_selected";
					var searchId = "tipo_scopo_search";
					document.getElementById(selectId).value = res[0]; // id recuperato
					document.getElementById(searchId).value = res[1]; // nome recuperato
					alert("Scopo selezionato.");
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
