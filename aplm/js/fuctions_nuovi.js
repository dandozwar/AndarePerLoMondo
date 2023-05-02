var DBluoghi = [];
var DBfonti = [];


function aggiornaDB(tipo) {
	if (tipo == 0) { // 0 sta per luogo
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
	} else if (tipo == 1) { // 1 sta per fonte
		$.ajax({
			type: "POST",
			url: "php/trova_fonti.php",
			success: function (resJ) {
				var res = JSON.parse(resJ);
				for (fonte of res) {
					DBfonti.push(fonte);
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	};
};

function luogo_search(tipo) {
	var searchId = tipo + "_viaggio_search";
	var listId = tipo + "_viaggio_list";
	var selectId = tipo + "_viaggio_selected";

	var luogoS = document.getElementById(searchId).value;
	var luogoId = document.querySelector("#" + listId + " option[value='" + luogoS + "']").dataset.id;
	var trovato = false;
	for (var l = 0; l < DBluoghi.length; l++) {
		if (DBluoghi[l][1] == luogoId) {
			trovato = true;
			break;
		};
	};
	if (trovato) {
		alert("Il luogo non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Luogo selezionato.");
		document.getElementById(selectId).value = luogoId;
	};
};

function fonti_search() {
	var searchId = "fonte_search";
	var listId = "fonte_list";
	var selectId = "fonte_selected";

	var fonteS = document.getElementById(searchId).value;
	var fonteId = document.querySelector("#" + listId + " option[value='" + fonteS + "']").dataset.id;
	var trovato = false;
	for (var f = 0; f < DBluoghi.length; f++) {
		if (DBfonti[f][1] == fontiId) {
			trovato = true;
			break;
		};
	};
	if (trovato) {
		alert("La fonte non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Fonte selezionata.");
		document.getElementById(selectId).value = fonteId;
	};
};


function return_back(tipo, nodo) {
	var nodoDiv = nodo.parentNode;
	nodoDiv.innerHTML = "<div class='popover_close' onclick='pop_out(this)'>X</div>";
	if (tipo == 0) { // 0 sta per luogo
		var luogoId = nodoDiv.id;
		var luogoTipo = "";
		if (luogoId == "pop_lp_viaggio") {
			luogoTipo = "lp";
			nodoDiv.innerHTML = nodoDiv.innerHTML + "<h3>Luogo di partenza del viaggio</h3>";
		} else if (luogoId == "pop_lm_viaggio") {
			luogoTipo = "lm";
			nodoDiv.innerHTML = nodoDiv.innerHTML + "<h3>Luogo meta del viaggio</h3>";
		};
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<div class='dropdown'> \
							<input type='button' value='Scegli dall&#8217;elenco'> \
							<div id='ddc_" + luogoTipo + "_viaggio' class='dropdown_content'></div> \
							</div> \
							<div class='blank_space'></div> \
							<h4>Se non hai trovato quello che cerchi</h4> \
							<label for='" + luogoTipo + "_viaggio_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='" + luogoTipo + "_viaggio_list' id='" + luogoTipo + "_viaggio_search' name='" + luogoTipo + "_viaggio_search'> \
							<datalist id='" + luogoTipo + "_viaggio_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='luogo_search(\"" + luogoTipo + "\")'> \
							<input type='text' id='" + luogoTipo + "_viaggio_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Aggiungi nuovo' onclick='apri_insert(0, this)'> \
							";
		aggiornaDB(0); // aggiornamento elenchi dei luoghi
		var radio_lp = "";
		var radio_lm = "";
		var optio = "";
		var rlist_lp = document.getElementById('ddc_lp_viaggio');
		var rlist_lm = document.getElementById('ddc_lm_viaggio');
		var dlist_lp = document.getElementById('lp_viaggio_list');
		var dlist_lm = document.getElementById('lm_viaggio_list');
		rlist_lp.innerHTML = "";
		rlist_lm.innerHTML = "";
		dlist_lp.innerHTML = "";
		dlist_lm.innerHTML = "";
		for (var l = 0; l < DBluoghi.length; l++) {
			radio_lp = "<div><input type='radio' id='lp_viaggio" + DBluoghi[l][0] + "' name='lp_viaggio' value='" + DBluoghi[l][0] + "'> <label for='lp_viaggio" + DBluoghi[l][0] + "'>" + DBluoghi[l][1] + "</label></div>";
			rlist_lp.insertAdjacentHTML('beforeend', radio_lp);

			radio_lm = "<div><input type='radio' id='lm_viaggio" + DBluoghi[l][0] + "' name='lm_viaggio' value='" + DBluoghi[l][0] + "'> <label for='lm_viaggio" + DBluoghi[l][0] + "'>" + DBluoghi[l][1] + "</label></div>";
			rlist_lm.insertAdjacentHTML('beforeend', radio_lm);

			optio = "<option data-id='" + DBluoghi[l][0] + "' value='" + DBluoghi[l][1] + "'>";
			dlist_lp.insertAdjacentHTML('beforeend', optio);
			dlist_lm.insertAdjacentHTML('beforeend', optio);
		};
	} else if (tipo == 1) { // 1 sta per fonte
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<h3>Fonte del viaggio</h3> \
							<div class='dropdown'> \
								<input type='button' value='Scegli dall&#8217;elenco'> \
								<div id='ddc_fonte' class='dropdown_content'></div> \
							</div> \
							<h4>Pagine specifiche:</h4> \
							<input type='text' id='pag_viaggio' maxlength='32'> \
							<div class='blank_space'></div> \
							<h4>Se non hai trovato quello che cerchi</h4> \
							<label for='fonte_search'>Cerca nel database:</label> \
							</br> \
							<input type='text' list='fonte_list' id='fonte_search' name='fonte_search'> \
							<datalist id='fonte_list'> \
							</datalist> \
							</br> \
							<input type='button' value='Seleziona' onclick='fonte_search()'> \
							<input type='text' id='fonte_selected' hidden='hidden'> \
							</br> \
							</br> \
							<input type='button' value='Aggiungi nuova' onclick='apri_insert(1, this)'>";
		aggiornaDB(1); // aggiornamento elenchi delle fonti
		var radio = "";
		var optio = "";
		var rlist = document.getElementById('ddc_fonte');
		var dlist = document.getElementById('fonte_list');
		rlist.innerHTML = "";
		dlist.innerHTML = "";
		for (var f = 0; f < DBfonti.length; f++) {
			radio = "<div><input type='radio' id='f" + DBfonti[f][0] + "' name='fonte' value='" + DBfonti[f][0] + "'> <label for='f" + DBfonti[f][0] + "'>" + DBfonti[f][1] + "</label></div>";
			rlist.insertAdjacentHTML('beforeend', radio);

			optio = "<option data-id='" + DBfonti[f][0] + "' value='" + DBfonti[f][1] + "'>";
			dlist.insertAdjacentHTML('beforeend', optio);
		};
	};
};

function insert_luog(nodo) {
	var res;
	var dati = new FormData();
	var nodoDiv = nodo.parentNode;
	var errori = new Array;
	var messaggio = "Inserisci correttamente: ";
	dati.append("nome", document.getElementById("nome").value);
	dati.append("lat", document.getElementById("lat").value);
	dati.append("lon", document.getElementById("lon").value);
	dati.append("uri", document.getElementById("uri").value);
	
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
				return_back(0, nodo);
				$.ajax({
					type: "POST",
					url: "php/trova_nuovoLuogo.php",
					data: dati,
					success: function (resJ) {
						res = JSON.parse(resJ);
						var luogoId = nodoDiv.id;
						var luogoTipo = "";
						if (luogoId == "pop_lp_viaggio") {
							luogoTipo = "lp";
						} else if (luogoId == "pop_lm_viaggio") {
							luogoTipo = "lm";
						};
						var selectId = luogoTipo + "_viaggio_selected";
						var searchId = luogoTipo + "_viaggio_search";
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

function insert_font(nodo) {
	var res;
	var dati = new FormData();
	var errori = new Array;
	var messaggio = "Inserisci correttamente";
	dati.append("cit_biblio", document.getElementById("cit_biblio").value);
	
	if (dati.get("cit_biblio").length == 0) {
		errori.push("la citazione bibliografica");
	};
	if (errori.length == 0) {
		$.ajax({
			type: "POST",
			url: "php/insert_fonte.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				return_back(1, nodo);
				$.ajax({
					type: "POST",
					url: "php/trova_nuovaFonte.php",
					data: dati,
					success: function (resJ) {
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

function apri_insert(tipo, nodo) {
	var nodoDiv = nodo.parentNode;
	if (tipo == 0) { // 0 sta per luogo
		nodoDiv.innerHTML = "<div class='popover_back' onclick='return_back(0, this)'>&#8592;</div> \
							<div class='popover_close' onclick='pop_out(this)'>X</div>"
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<h3>Luogo di partenza del viaggio</h3> \
							<form id='insert_luogo'> \
								<label for='nome'>Nome:</label> \
								</br> \
								<input type='text' id='nome' maxlength='64'> \
								</br> \
								<label for='lat'>Latitudine:</label> \
								</br> \
								<input type='number' id='lat'  min='-90' max='90'> \
								</br> \
								<label for='lon'>Longitudine:</label> \
								</br> \
								<input type='number' id='lon'  min='-180' max='180'> \
								</br> \
								<label for='uri'>URI:</label> \
								</br> \
								<input type='url' id='uri' maxlength='256'> \
							</form> \
							</br> \
							<input type='button' id='insert_l' value='Inserisci luogo' onclick='insert_luog(this)'>";
	} else if (tipo == 1) { // 1 sta per fonte
		nodoDiv.innerHTML = "<div class='popover_back' onclick='return_back(1, this)'>&#8592;</div> \
							<div class='popover_close' onclick='pop_out(this)'>X</div>"
		nodoDiv.innerHTML = nodoDiv.innerHTML +
							"<h3>Fonte del viaggio</h3> \
							<form id='insert_fonte'> \
								<label for='cit_biblio'>Citazione bibliografica:</label> \
								</br> \
								<input type='text' id='cit_biblio' maxlength='256'> \
							</form> \
							</br> \
							<input type='button' id='insert_f' value='Inserisci fonte' onclick='insert_font(this)'>";
	};
};
