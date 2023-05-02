// FUNZIONI MODIFICA DI UN CAMPO DELL'EVENTO //////////////////////////////////
function modifica_campo(idFonte, campo) {
	window.location.assign("edit_fonte.php?id=" + idFonte + "&campo=" + campo);
};

function invia_campo(idFonte, campo) {
	var dati = new FormData();
	var flagErrore = false;
	dati.set('id', idFonte);
	switch (campo) {
		case 'au':
			dati.set('campo', 'autore');
			var auto = document.getElementById('au').value;
			if (auto != "") {
				dati.append('valore', auto);
			} else {
				flagErrore = true;
			};
			break;
		case 'ti':
			dati.set('campo', 'titolo');
			var tito = document.getElementById('ti').value;
			if (tito != "") {
				dati.append('valore', tito);
			} else {
				flagErrore = true;
			};
			break;
		case 'tv':
			dati.set('campo', 'titolo_volume');
			var tivo = document.getElementById('tv').value;
			if (tivo != "") {
				dati.append('valore', tivo);
			} else {
				flagErrore = true;
			};
			break;
		case 'tr':
			dati.set('campo', 'titolo_rivista');
			var tiri = document.getElementById('tr').value;
			if (tiri != "") {
				dati.append('valore', tiri);
			} else {
				flagErrore = true;
			};
			break;
		case 'nu':
			dati.set('campo', 'numero');
			var nume = document.getElementById('nu').value;
			if (nume != "") {
				dati.append('valore', nume);
			} else {
				flagErrore = true;
			};
			break;
		case 'cu':
			dati.set('campo', 'curatore');
			var cura = document.getElementById('cu').value;
			if (cura != "") {
				dati.append('valore', cura);
			} else {
				flagErrore = true;
			};
			break;
		case 'lu':
			dati.set('campo', 'luogo');
			var luog = document.getElementById('lu').value;
			if (luog != "") {
				dati.append('valore', luog);
			} else {
				flagErrore = true;
			};
			break;
		case 'ed':
			dati.set('campo', 'editore');
			var edit = document.getElementById('ed').value;
			if (edit != "") {
				dati.append('valore', edit);
			} else {
				flagErrore = true;
			};
			break;
		case 'ns':
			dati.set('campo', 'nome_sito');
			var nome = document.getElementById('ns').value;
			if (nome != "") {
				dati.append('valore', nome);
			} else {
				flagErrore = true;
			};
			break;
		case 'an':
			dati.set('campo', 'anno');
			var anno = document.getElementById('an').value;
			if (anno != "") {
				dati.append('valore', anno);
			} else {
				flagErrore = true;
			};
			break;
		case 'co':
			dati.set('campo', 'collana');
			var coll = document.getElementById('co').value;
			if (coll != "") {
				dati.append('valore', coll);
			} else {
				flagErrore = true;
			};
			break;
		case 'pag':
			dati.set('campo', 'pagine');
			var pagi = document.getElementById('pag').value;
			if (pagi != "") {
				dati.append('valore', pagi);
			} else {
				flagErrore = true;
			};
			break;
		case 'url':
			dati.set('campo', 'url');
			var url = document.getElementById('url').value;
			if (url != "") {
				dati.append('valore', url);
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
			url: "php/modifica_campo_fonte.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == 'Modifica effettuata.') {
					window.location.assign("edit_fonte.php?id=" + idFonte);
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
