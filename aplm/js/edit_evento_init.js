// BREADCRUMB E USCITA SENZA CONFERMA /////////////////////////////////////////
var campo = new URLSearchParams(window.location.search).get('campo');
if (campo != null) {
	// breadcrumb
	var breadcrumb = document.getElementById('breadcrumb');
	switch (campo) {
		case 'ti':
			campo = 'titolo';
			break;
		case 'dd':
			campo = 'didascalia';
			break;
		case 'di':
			campo = 'data inizio';
			break;
		case 'df':
			campo = 'data fine';
			break;
		case 'im':
			campo = 'immagine';
			break;
		case 'uri':
			campo = 'URI';
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
