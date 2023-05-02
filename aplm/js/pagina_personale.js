// FUNZIONI DI GESTIONE DELLE FONTI ///////////////////////////////////////////
function modifica_fonte(idFonte) {
	window.location.assign('edit_fonte.php?id=' + idFonte + '');
};

function elimina_fonte(idFonte) {
	if (confirm('È possibile eliminare una fonte solo quando non ci sono viaggi collegati a essa. Procedere?')) {
		var user = new URLSearchParams(window.location.search).get('user');
		$.ajax({
			type: 'POST',
			url: 'php/delete_fonte.php',
			data: {'id': idFonte, 'nick': user},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Fonte eliminata.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

// FUNZIONI DI GESTIONE DEI VIAGGI ////////////////////////////////////////////
function modifica_viaggio(id) {
	window.location.assign('edit_viaggio.php?id=' + id + '');
};

function crea_viaggio() {
	var res;
	var id_nuovo;
	var user = new URLSearchParams(window.location.search).get('user');
	$.ajax({
		type: 'POST',
		url: 'php/insert_viaggio.php',
		data: {'nick': user},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) { 
				id_nuovo = res[0];
				modifica_viaggio(id_nuovo);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

function elimina_viaggio(id) {
	if (confirm('Eliminare definitivamente questo viaggio?')) {
		var user = new URLSearchParams(window.location.search).get('user');
		$.ajax({
			type: 'POST',
			url: 'php/delete_viaggio.php',
			data: {'id': id, 'nick': user},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Viaggio eliminato.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

// FUNZIONI DI GESTIONE DELLE PERSONE /////////////////////////////////////////
function modifica_persona(idPersona) {
	window.location.assign('edit_persona.php?id=' + idPersona + '');
};

function crea_persona() {
	var res;
	var id_nuovo;
	var user = new URLSearchParams(window.location.search).get('user');
	$.ajax({
		type: 'POST',
		url: 'php/insert_persona.php',
		data: {'nick': user},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) { 
				id_nuovo = res[0];
				modifica_persona(id_nuovo);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

function elimina_persona(idPersona) {
	if (confirm('Eliminare definitivamente questa persona?')) {
		var user = new URLSearchParams(window.location.search).get('user');
		$.ajax({
			type: 'POST',
			url: 'php/delete_persona.php',
			data: {'id': idPersona, 'nick': user},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Persona eliminata.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};

// FUNZIONI DI GESTIONE DEGLI SCOPI ///////////////////////////////////////////
function modifica_scopo(idScopo) {
	window.location.assign('edit_scopo.php?id=' + idScopo + '');
};

function crea_scopo() {
	var res;
	var id_nuovo;
	var user = new URLSearchParams(window.location.search).get('user');
	$.ajax({
		type: 'POST',
		url: 'php/insert_scopo.php',
		data: {'nick': user},
		success: function (resJ) {
			res = JSON.parse(resJ);
			if (Number.isInteger(res[0])) { 
				id_nuovo = res[0];
				modifica_scopo(id_nuovo);
			} else {
				alert(res[0]);
			};
		},
		async: false
	});
};

function elimina_scopo(idScopo) {
	if (confirm('Eliminare definitivamente questo scopo?')) {
		var user = new URLSearchParams(window.location.search).get('user');
		$.ajax({
			type: 'POST',
			url: 'php/delete_scopo.php',
			data: {'id': idScopo, 'nick': user},
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Scopo eliminato.') {
					window.location.reload();
				};
			},
			async: false
		});
	};
};
