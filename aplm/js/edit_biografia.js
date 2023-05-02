// FUNZIONI GESTIONE DI UN EVENTO /////////////////////////////////////////////
function modifica_evento(idEvento) {
	window.location.assign("edit_evento.php?id=" + idEvento + "");
};

function elimina_evento(idEvento) {
	if (confirm('Eliminare definitivamente questo evento?')) {
		$.ajax({
			type: 'POST',
			url: 'php/delete_evento.php',
			data: {'id': idEvento},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Evento eliminato.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

function crea_evento(idBio) {
	var res;
	$.ajax({
		type: 'POST',
		url: 'php/insert_evento.php',
		data: {'biografia': idBio},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) {
				modifica_evento(res[0]);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

// FUNZIONI MODIFICA DI UN CAMPO DELLA BIOGRAFIA //////////////////////////////
function modifica_campo(persona, campo) {
	window.location.assign("edit_biografia.php?persona=" + persona + "&campo=" + campo);
};

function invia_campo(idPersona, campo, versione = null) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('persona', idPersona);
	switch (campo) {
		case 'pr':
			dati.set('campo', 'presentazione');
			var pres = document.getElementById('pr').value;
			if (pres != "") {
				dati.append('valore', pres);
			} else {
				flagErrore = true;
			};
			break;
		case 'de':
			dati.set('campo', 'descrizione');
			var desc = document.getElementById('de').value;
			if (desc != "") {
				dati.append('valore', desc);
			} else {
				flagErrore = true;
			};
			break;
		case 'v1':
			dati.set('campo', 'viaggio1');
			if (document.querySelector('input[name="v1_bio"]:checked')) {
				var check_radio = document.querySelector('input[name="v1_bio"]:checked').value;
				dati.set('valore', check_radio);
			} else {
				flagErrore = true;
			};
			break;
		case 'v2':
			dati.set('campo', 'viaggio2');
			if (document.querySelector('input[name="v2_bio"]:checked')) {
				var check_radio = document.querySelector('input[name="v2_bio"]:checked').value;
				dati.set('valore', check_radio);
			} else {
				flagErrore = true;
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
			url: "php/modifica_campo_biografia.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ != 'Viaggio 1 e Viaggio 2 sono uguali.') {
					window.location.assign("edit_biografia.php?persona=" + idPersona);
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
