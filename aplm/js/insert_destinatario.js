function invia_destinatario(id) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', id);
	if (document.querySelector('input[name="dest_scopo"]:checked')) {
		var check_radio = document.querySelector('input[name="dest_scopo"]:checked').value;
		dati.set('destinatario', check_radio);
	} else if (document.getElementById('dest_scopo_selected').value != "") {
		var check_select = document.getElementById('dest_scopo_selected').value;
		dati.set('destinatario', check_select);
	} else {
		flagErrore = true;
	};
	if (flagErrore == false) {
		dati.set('id', id);
		$.ajax({
			type: "POST",
			url: "php/insert_destinatario.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Destinatario aggiunto.') {
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
	var searchId = "dest_scopo_search";
	var listId = "dest_scopo_list";
	var selectId = "dest_scopo_selected";
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
