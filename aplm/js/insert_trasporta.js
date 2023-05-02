function invia_merce(id) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	if (document.querySelector('input[name="merc_tappa"]:checked')) {
		var check_radio = document.querySelector('input[name="merc_tappa"]:checked').value;
		dati.set('merce', check_radio);
	} else if (document.getElementById('merc_tappa_selected').value != "") {
		var check_select = document.getElementById('merc_tappa_selected').value;
		dati.set('merce', check_select);
	} else {
		flagErrore = true;
	};	
	if (flagErrore == false) {
		dati.set('id', id);
		$.ajax({
			type: "POST",
			url: "php/insert_trasporta.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Merce aggiunta a quelle trasportate.') {
					window.location.assign("edit_tappa.php?id=" + id);
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
var DBmerci = [];

// FUNZIONI PER L'AGGIUNTA DI NUOVE ENTITA' NEL DATABASE //////////////////////
function aggiornaDB(tipo) {
	DBmerci = [];
	$.ajax({
		type: "POST",
		url: "php/trova_merci.php",
		success: function (resJ) {
			var res = JSON.parse(resJ);
			for (merce of res) {
					DBmerci.push(merce);
			};
		},
		processData: false,
		contentType: false,
		async: false
	});
};

// FUNZIONI SPECIFICHE PER LE MERCI ///////////////////////////////////////////
function return_back(tipoOgg, nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var nodoDiv = document.getElementById('pop_merc_tappa');
	nodoDiv.innerHTML = "";
	aggiornaDB(0); // aggiornamento elenchi delle merci
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<div class='dropdown'> \
						<input type='button' value='Scegli dall&#8217;elenco'> \
						<div id='ddc_merc_tappa' class='dropdown_content'></div> \
						</div> \
						<div class='blank_space'></div> \
						<h2>Se non hai trovato quello che cerchi</h2> \
						<label for='merc_tappa_search'>Cerca nel database:</label> \
						</br> \
						<input type='text' list='merc_tappa_list' id='merc_tappa_search' name='merc_tappa_search'> \
						<datalist id='merc_tappa_list'> \
						</datalist> \
						</br> \
						<input type='button' value='Seleziona' onclick='merc_search()'> \
						<input type='text' id='merc_tappa_selected' hidden='hidden'> \
						</br> \
						</br> \
						<input type='button' value='Inserisci nuova' onclick='apri_insert(this)'>";
	var radio_merc = "";
	var optio = "";
	var rlist_merc = document.getElementById('ddc_merc_tappa');
	var dlist_merc = document.getElementById('merc_tappa_list');
	rlist_merc.innerHTML = "";
	dlist_merc.innerHTML = "";
	for (var m = 0; m < DBmerci.length; m++) {
		radio_merc = "<div><input type='radio' id='merc" + DBmerci[m][0] + "' name='merc_tappa' value='" + DBmerci[m][0] + "'> <label for='merc" + DBmerci[m][0] + "'>" + DBmerci[m][1] + ', quantità ' + DBmerci[m][2] + ', valore ' + DBmerci[m][3] + "</label></div>";
		rlist_merc.insertAdjacentHTML('beforeend', radio_merc);
		optio = "<option data-id='" + DBmerci[m][0] + "' value='" + DBmerci[m][1] + ', quantità ' + DBmerci[m][2] + ', valore ' + DBmerci[m][3] + "'>";
		dlist_merc.insertAdjacentHTML('beforeend', optio);
	};
};

function apri_insert(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.setAttribute("hidden", "hidden");
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<a href='#' onclick='return_back(this)'>Torna alla scelta della merce</a>";
	nodoDiv.innerHTML = nodoDiv.innerHTML +
						"<p>Inserire il tipo di merce e, se conosciuti, la quantità come numero e unità di misura e il valore della merce (specificando la valuta).</p> \
						<form id='insert_merce'> \
							<label for='tipo'>Tipo:</label> \
							</br> \
							<input type='text' id='tipo' name='tipo' maxlength='64'> \
							</br> \
							<label for='quantita'>Quantità:</label> \
							</br> \
							<input type='text' id='quantita' name='quantita' maxlength='32'> \
							</br> \
							<label for='valore'>Valore:</label> \
							</br> \
							<input type='text' id='valore' name='valore' maxlength='32'> \
							</br> \
						</form> \
						</br> \
						<input type='button' id='insert_l' value='Inserisci merce' onclick='insert_merc(this)'>";
};

function merc_search() {
	var searchId = "merc_tappa_search";
	var listId = "merc_tappa_list";
	var selectId = "merc_tappa_selected";
	var mercS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var mercId = document.querySelector("#" + listId + " option[value='" + mercS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("La merce non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Merce selezionata.");
		document.getElementById(selectId).value = mercId;
	};
};

function insert_merc(nodo) {
	var nodoInvia = document.getElementById("invia");
	nodoInvia.removeAttribute("hidden");
	var res;
	var form = document.getElementById("insert_merce");
	var dati = new FormData(form);
	var nodoDiv = nodo.parentNode;
	var errori = new Array;
	var messaggio = "Inserisci correttamente: ";
	if (dati.get("tipo").length == 0) {
		errori.push("tipo");
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_merce.php",
			data: dati,
			success: function (resJ) {
				if (resJ != 'Merce già inserita.') {
					return_back(nodo);
					res = JSON.parse(resJ);
					var selectId = "merc_tappa_selected";
					var searchId = "merc_tappa_search";
					document.getElementById(selectId).value = res[0]; // id recuperato
					document.getElementById(searchId).value = res[1]; // nome recuperato
					alert("Merce selezionata.");
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
