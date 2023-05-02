function invia_occu(id) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	if (document.querySelector('input[name="occu_pers"]:checked')) {
		var check_radio = document.querySelector('input[name="occu_pers"]:checked').value;
		dati.set('occupazione', check_radio);
	} else if (document.getElementById('occu_pers_selected').value != "") {
		var check_select = document.getElementById('occu_pers_selected').value;
		dati.set('occupazione', check_select);
	} else {
		flagErrore = true;
	};
	// scrittura stringa
	var data_inizio = "";
	var anno_inizio = document.getElementById('di_anno').value;
	var mese_inizio = document.getElementById('di_mese').value;
	var gior_inizio = document.getElementById('di_gior').value;
	if (anno_inizio != "") {
		if (parseInt(anno_inizio) > 1492 && parseInt(anno_inizio < 476)) {
			flagErrore = true;
		} else {
			if (parseInt(anno_inizio) < 1000) {
				anno_inizio = '0' + anno_inizio;
			};
			if (mese_inizio == "") {
				data_inizio = anno_inizio + '-00-00';
			} else {
				if (parseInt(mese_inizio) < 1 && parseInt(mese_inizio > 12)) {
					flagErrore = true;
				} else {
					if (parseInt(mese_inizio) < 10) {
						mese_inizio = '0' + mese_inizio;
					};
					if (gior_inizio == "") {
						data_inizio = anno_inizio + '-' + mese_inizio + '-00';
					} else {
						if (parseInt(mese_inizio) < 1 && parseInt(mese_inizio > 12)) {
							flagErrore = true;
						} else {
							if (parseInt(gior_inizio) < 10) {
								gior_inizio = '0' + gior_inizio;
							};
							data_inizio = anno_inizio + '-' + mese_inizio + '-' + gior_inizio;
						};
					};
				};
			};
		};
	};
	var data_fine = "";
	var anno_fine = document.getElementById('df_anno').value;
	var mese_fine = document.getElementById('df_mese').value;
	var gior_fine = document.getElementById('df_gior').value;
	if (anno_fine != "") {
		if (parseInt(anno_fine) < 1000) {
			anno_fine = '0' + anno_fine;
		};
		if (mese_fine == "") {
			data_fine = anno_fine + '-00-00';
		} else {
			if (parseInt(mese_fine) < 10) {
				mese_fine = '0' + mese_fine;
			};
			if (gior_fine == "") {
				data_fine = anno_fine + '-' + mese_fine + '-00';
			} else {
				if (parseInt(mese_fine) < 10) {
					gior_fine = '0' + gior_fine;
				};
				data_fine = anno_fine + '-' + mese_fine + '-' + gior_fine;
			};
		};
	};
	if (flagErrore == false) {
		dati.set('id', id);
		dati.set('data_inizio', data_inizio);
		dati.set('data_fine', data_fine);
		$.ajax({
			type: "POST",
			url: "php/insert_lavora_come.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Occupazione aggiunta a quelle svolte.') {
					window.location.assign("edit_persona.php?id=" + id);
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
var DBoccup = [];

// FUNZIONI PER L'AGGIUNTA DI NUOVE ENTITA' NEL DATABASE //////////////////////
function aggiornaDB(tipo) {
	DBoccup = [];
	$.ajax({
		type: "POST",
		url: "php/trova_occupazioni.php",
		success: function (resJ) {
			var res = JSON.parse(resJ);
			for (occup of res) {
					DBoccup.push(occup);
			};
		},
		processData: false,
		contentType: false,
		async: false
	});
};

// FUNZIONI SPECIFICHE PER LE OCCUPAZIONI /////////////////////////////////////
function return_back(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var nodoDiv = document.getElementById('pop_occu_pers');
	nodoDiv.innerHTML = "";
	aggiornaDB(0); // aggiornamento elenchi delle occupazioni
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<div class='dropdown'> \
						<input type='button' value='Scegli dall&#8217;elenco'> \
						<div id='ddc_occu_pers' class='dropdown_content'></div> \
						</div> \
						<div class='blank_space'></div> \
						<h2>Se non hai trovato quello che cerchi</h2> \
						<label for='occu_pers_search'>Cerca nel database:</label> \
						</br> \
						<input type='text' list='occu_pers_list' id='occu_pers_search' name='occu_pers_search'> \
						<datalist id='occu_pers_list'> \
						</datalist> \
						</br> \
						<input type='button' value='Seleziona' onclick='occu_search()'> \
						<input type='text' id='occu_pers_selected' hidden='hidden'> \
						</br> \
						</br> \
						<input type='button' value='Inserisci nuova' onclick='apri_insert(this)'>\
						</br> \
						</br> \
						<table> \
							<tr><td></td><th>Anno:</th><th>Mese:</th><th>Giorno:</th> \
							<tr><th>Data inizio:</th><td><input type='number' id='di_anno' name='di_anno' min='476' max='1492'/></td><td><input type='number' id='di_mese' name='di_mese' min='1' max='12'/></td><td><input type='number' id='di_gior' name='di_gior' min='1' max='31'/></td></tr> \
							<tr><th>Data fine:</th><td><input type='number' id='df_anno' name='df_anno' min='476' max='1492'/></td><td><input type='number' id='df_mese' name='df_mese' min='1' max='12'/></td><td><input type='number' id='df_gior' name='df_gior' min='1' max='31'/></td></tr> \
						</table>";
	var radio_occu = "";
	var optio = "";
	var rlist_occu = document.getElementById('ddc_occu_pers');
	var dlist_occu = document.getElementById('occu_pers_list');
	rlist_occu.innerHTML = "";
	dlist_occu.innerHTML = "";
	for (var o = 0; o < DBoccup.length; o++) {
		radio_occu = "<div><input type='radio' id='occu" + DBoccup[o][0] + "' name='occu_pers' value='" + DBoccup[o][0] + "'> <label for='occu" + DBoccup[o][0] + "'>" + DBoccup[o][1] + "</label></div>";
		rlist_occu.insertAdjacentHTML('beforeend', radio_occu);
		optio = "<option data-id='" + DBoccup[o][0] + "' value='" + DBoccup[o][1] + "'>";
		dlist_occu.insertAdjacentHTML('beforeend', optio);
	};
};

function apri_insert(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<a href='#' onclick='return_back(this)'>Torna alla scelta dell&#8217;occupazione</a>";
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<p>Inserire l&#8217;attività.</p> \
						<form id='insert_occupazione'> \
							<label for='tipo'>Attività:</label> \
							</br> \
							<input type='text' id='tipo' name='attivita' maxlength='32'> \
						</form> \
						</br> \
						<input type='button' id='insert_o' value='Inserisci' onclick='insert_occu(this)'>";
};

function occu_search() {
	var searchId = "occu_pers_search";
	var listId = "occu_pers_list";
	var selectId = "occu_pers_selected";
	var occuS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var occuId = document.querySelector("#" + listId + " option[value='" + occuS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("L&#8217;occupazione non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Occupazione selezionata.");
		document.getElementById(selectId).value = occuId;
	};
};

function insert_occu(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var res;
	var form = document.getElementById("insert_occupazione");
	var dati = new FormData(form);
	var nodoDiv = nodo.parentNode;
	var errori = new Array;
	var messaggio = "Inserisci correttamente: ";
	if (dati.get("attivita").length == 0) {
		errori.push("attività");
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_occupazione.php",
			data: dati,
			success: function (resJ) {
				if (resJ != 'Occupazione già inserita.') {
					return_back(nodo);
					res = JSON.parse(resJ);
					var selectId = "occu_pers_selected";
					var searchId = "occu_pers_search";
					document.getElementById(selectId).value = res[0]; // id recuperato
					document.getElementById(searchId).value = res[1]; // nome recuperato
					alert("Occupazione selezionata.");
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
