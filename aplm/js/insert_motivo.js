function invia_motivo(tipo, id) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	if (tipo == 'v') {
		dati.set('tipo', 'viaggio');
		if (document.querySelector('input[name="scop_viaggio"]:checked')) {
			var check_radio = document.querySelector('input[name="scop_viaggio"]:checked').value;
			dati.set('scopo', check_radio);
		} else if (document.getElementById('scop_viaggio_selected').value != "") {
			var check_select = document.getElementById('scop_viaggio_selected').value;
			dati.set('scopo', check_select);
		} else {
			flagErrore = true;
		};
		if (flagErrore == false) {
			dati.set('id', id);
			$.ajax({
				type: "POST",
				url: "php/insert_motivo.php",
				data: dati,
				success: function (resJ) {
					alert(resJ);
					if (resJ == 'Motivo aggiunto.') {
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
		if (document.querySelector('input[name="scop_tappa"]:checked')) {
			var check_radio = document.querySelector('input[name="scop_tappa"]:checked').value;
			dati.set('scopo', check_radio);
		} else if (document.getElementById('scop_tappa_selected').value != "") {
			var check_select = document.getElementById('scop_tappa_selected').value;
			dati.set('scopo', check_select);
		} else {
			flagErrore = true;
		};
		if (flagErrore == false) {
			dati.set('id', id);
			$.ajax({
				type: "POST",
				url: "php/insert_motivo.php",
				data: dati,
				success: function (resJ) {
					alert(resJ);
					if (resJ = 'Motivo aggiunto.') {
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

// FUNZIONI SPECIFICHE PER I SCOPI ////////////////////////////////////////////
function scop_search(tipo) {
	if (tipo == 'v') {
		var searchId = "scop_viaggio_search";
		var listId = "scop_viaggio_list";
		var selectId = "scop_viaggio_selected";
	} else if (tipo == 't') {
		var searchId = "scop_tappa_search";
		var listId = "scop_tappa_list";
		var selectId = "scop_tappa_selected";
	};
	var scopS = document.getElementById(searchId).value;
	var trovato = true;
	try {
		var scopId = document.querySelector("#" + listId + " option[value='" + scopS + "']").dataset.id;
	} catch {
		trovato = false;
	};
	if (trovato == false) {
		alert("Lo scopo non è presente nel database.");
		document.getElementById(searchId).value = "";
	} else {
		alert("Scopo selezionato.");
		document.getElementById(selectId).value = scopId;
	};
};
