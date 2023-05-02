function invia_mandante(id) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	if (document.querySelector('input[name="mand_scopo"]:checked')) {
		var check_radio = document.querySelector('input[name="mand_scopo"]:checked').value;
		dati.set('mandante', check_radio);
	} else if (document.getElementById('mand_scopo_selected').value != "") {
		var check_select = document.getElementById('mand_scopo_selected').value;
		dati.set('mandante', check_select);
	} else {
		flagErrore = true;
	};
	if (flagErrore == false) {
		dati.set('id', id);
		$.ajax({
			type: "POST",
			url: "php/insert_mandante.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Mandante aggiunto.') {
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

// FUNZIONI SPECIFICHE PER LE PERSONE /////////////////////////////////////////
function pers_search() {
	var searchId = "mand_scopo_search";
	var listId = "mand_scopo_list";
	var selectId = "mand_scopo_selected";
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
	};
};
