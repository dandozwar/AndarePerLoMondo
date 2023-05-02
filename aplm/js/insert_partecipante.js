function invia_partecipante(tipo, id) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	if (tipo == 'v') {
		dati.set('tipo', 'viaggio');
		if (document.querySelector('input[name="part_viaggio"]:checked')) {
			var check_radio = document.querySelector('input[name="part_viaggio"]:checked').value;
			dati.set('partecipante', check_radio);
		} else if (document.getElementById('part_viaggio_selected').value != "") {
			var check_select = document.getElementById('part_viaggio_selected').value;
			dati.set('partecipante', check_select);
		} else {
			flagErrore = true;
		};
		if (flagErrore == false) {
			dati.set('id', id);
			$.ajax({
				type: "POST",
				url: "php/insert_partecipante.php",
				data: dati,
				success: function (resJ) {
					alert(resJ);
					if (resJ == 'Partecipante aggiunto.') {
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
	} else if (tipo == 't') {
		dati.set('tipo', 'tappa');
		if (document.querySelector('input[name="part_tappa"]:checked')) {
			var check_radio = document.querySelector('input[name="part_tappa"]:checked').value;
			dati.set('partecipante', check_radio);
		} else if (document.getElementById('part_tappa_selected').value != "") {
			var check_select = document.getElementById('part_tappa_selected').value;
			dati.set('partecipante', check_select);
		} else {
			flagErrore = true;
		};
		if (flagErrore == false) {
			dati.set('id', id);
			$.ajax({
				type: "POST",
				url: "php/insert_partecipante.php",
				data: dati,
				success: function (resJ) {
					alert(resJ);
					if (resJ = 'Partecipante aggiunto.') {
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
};

// FUNZIONI SPECIFICHE PER LE PERSONE /////////////////////////////////////////
function pers_search(tipo) {
	if (tipo == 'v') {
		var searchId = "part_viaggio_search";
		var listId = "part_viaggio_list";
		var selectId = "part_viaggio_selected";
	} else if (tipo == 't') {
		var searchId = "part_tappa_search";
		var listId = "part_tappa_list";
		var selectId = "part_tappa_selected";
	};
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
