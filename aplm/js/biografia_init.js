// Trovo l'id della persona
var idpersona = document.getElementsByTagName("h1")[0].id.substring(1);

// Imposto il breadcrumb
var breadcrumb = document.getElementById("breadcrumb");
var ultimaPagina = document.referrer
var nodoHome = document.createElement("li");
nodoHome.innerHTML = "<a href='./index.php'>Home</a>"
breadcrumb.appendChild(nodoHome);
var persona;
$.ajax({
	type: "POST",
	url: "php/trova_nome_cognome.php",
	data: {id: idpersona},
	success: function(resJ) { persona = JSON.parse(resJ);},
	async: false
});
var nodoPresentazione = document.createElement("li");
nodoPresentazione.innerHTML = "<a href='./presentazione.php?persona=" + idpersona + "'>Presentazione " + persona[0] + " " + persona[1] +"</a>";
breadcrumb.appendChild(nodoPresentazione);
var nodoBio = document.createElement("li");
nodoBio.innerHTML = "Biografia";
breadcrumb.appendChild(nodoBio);

// Funzioni di conversione delle date
function get_anno (data) {
	return data.substr(0, 4);
};

function get_mese (data) {
	data = data.substr(5, 2);
	if (data.substr(0, 1) == "0") {
		data = data.substr(1, 1);
	};
	return data;
};

function get_giorno (data) {
	data = data.substr(8, 2);
	if (data.substr(0, 1) == "0") {
		data = data.substr(1, 1);
	};
	return data;
};

// Inizializzazione dell'oggetto JSON e dell'array dei viaggi
var oggetto = new Object();
var viaggi = new Array();
// Titolo e descrizione biografia
var res;
$.ajax({
	type: "POST",
	url: "php/trova_biografia.php",
	data: {id: idpersona},
	success: function(resJ) { res = JSON.parse(resJ);},
	async: false
});
oggetto.text = { "headline" : res[0] + " " + res[1], "text": res[2] };
// Eventi e viaggi
$.ajax({
	type: "POST",
	url: "php/trova_eventi_viaggi.php",
	data: {id: res[3]},
	success: function (resJ) { res = JSON.parse(resJ);},
	async: false
});
// Creazione oggetto JSON
oggetto.events = new Array();
for (var i = 0; i < res.length; i++) {
	var giorno, mese;
	var obj = new Object();
	if (res[i][0] == "evento") {
		var text = res[i][4];
		if (res[i][8] != null) {
			text = res[i][4] + "<p><a href='" + res[i][8] +  "' target='_blank'>Vai a più dettagli su siti esterni</a>.<p>";
		};
		obj.text = { "headline" : res[i][3], "text": text };
		obj.start_date = new Object();
		obj.start_date.year = get_anno(res[i][1]);
		mese = get_mese(res[i][1]);
		if (mese != "0") {
			obj.start_date.month = mese;
		};
		giorno = get_giorno(res[i][1]);
		if (giorno != "0") {
			obj.start_date.day = giorno;
		};
		if (res[i][2] != null) {
			obj.end_date = new Object();
			obj.end_date.year = get_anno(res[i][2]);
			mese = get_mese(res[i][2]);
			if (mese != "0") {
				obj.end_date.month = mese;
			};
			giorno = get_giorno(res[i][2]);
			if (giorno != "0") {
				obj.end_date.day = giorno;
			};
		};
		if (res[i][5] != null) {
			obj.media = new Object();
			obj.media.url = res[i][5];
			obj.media.caption = res[i][6];
			obj.media.credit = res[i][7];
		}
	};
	if (res[i][0] == "viaggio") {
		var text = "<p>Viaggio da " + res[i][3] + " con meta " + res[i][5] + ".</p><p><a href='./viaggio.php?viaggio=" + res[i][1] +  "' target='_self'>Vedi dettagli viaggio</a>.</p>";
		obj.text = { "headline" : res[i][6], "text": text};
		obj.start_date = new Object();
		obj.start_date.year = get_anno(res[i][2]);
		mese = get_mese(res[i][2]);
		if (mese != "0") {
			obj.start_date.month = mese;
		};
		giorno = get_giorno(res[i][2]);
		if (giorno != "0") {
			obj.start_date.day = giorno;
		};
		if (res[i][2] != res[i][4]) {
			obj.end_date = new Object();
			obj.end_date.year = get_anno(res[i][4]);
			mese = get_mese(res[i][4]);
			if (mese != "0") {
				obj.end_date.month = mese;
			};
			giorno = get_giorno(res[i][4]);
			if (giorno != "0") {
				obj.end_date.day = giorno;
			};
		};
		viaggi.push([res[i][1], res[i][7], res[i][8]]);
	};
	oggetto.events.push(obj);
};

// Do in pasto l'oggetto JSON alla libreria TimelineJS
var timeline_json = oggetto;
var additionalOptions = { font: './css/timeline_fonts.css' };
window.timeline = new TL.Timeline('timeline-embed', timeline_json, additionalOptions);
