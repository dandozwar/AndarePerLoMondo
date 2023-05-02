// BREADCRUMB E USCITA SENZA CONFERMA /////////////////////////////////////////
var campo = new URLSearchParams(window.location.search).get('campo');
if (campo != null) {
	// breadcrumb
	var breadcrumb = document.getElementById('breadcrumb');
	switch (campo) {
		case 'pr':
			campo = 'presentazione';
			break;
		case 'de':
			campo = 'descrizione';
			break;
		case 'v1':
			campo = 'viaggio 1';
			break;
		case 'v2':
			campo = 'viaggio 2';
			break;
		case 'pu':
			campo = 'visibilità';
			break;
		default:
			alert('Errore!');
	};
	var nodoCampo = document.createElement('li');
	nodoCampo.innerHTML = 'Modifica ' + campo;
	breadcrumb.appendChild(nodoCampo);

	/*
	// impedisce l'uscita senza conferma nel caso siano stati modificati dei dati
	conferma = false; 
	window.onbeforeunload = function() {
		alert('confermo?');
		if (conferma) {
			return 'I dati non salvati saranno persi.'; 
		};
	};

	$('"select,input,textarea').change(function() {
		conferma = true;
	});
	*/
};
