// Trova l'id del viaggio e la scala del viaggio
var idviaggio = document.getElementsByTagName("h2")[0].id.substring(1);
var scala = document.getElementsByTagName("h2")[0].className;

// Imposto il breadcrumb
var breadcrumb = document.getElementById("breadcrumb");
var ultimaPagina = document.referrer
if (ultimaPagina.substr(0, 23) == 'https://localhost/aplm/') {
	var nodoHome = document.createElement("li");
	nodoHome.innerHTML = "<a href='./index.php'>Home</a>"
	breadcrumb.appendChild(nodoHome);
	if (ultimaPagina.substr(23, 17) == 'presentazione.php') {
		var nodoPresentazione = document.createElement("li");
		var idpersona = parseInt(ultimaPagina.substr(49, ultimaPagina.length - 49));
		var persona;
		var dati = new FormData();
		dati.append("id", idpersona);
		$.ajax({
			url: "php/post_NomeCognome.php",
			type: "POST",
			data: dati,
			success: function (resJ) {persona = JSON.parse(resJ);},
			cache: false,
			contentType: false,
			processData: false,
			async: false
		});
		nodoPresentazione.innerHTML = "<a href='./presentazione.php?persona=" + idpersona + "'>Presentazione " + persona[0] + " " + persona[1] +"</a>";
		breadcrumb.appendChild(nodoPresentazione);
	} else if (ultimaPagina.substr(23, 11) == 'esplora.php') {
		var nodoEsplora = document.createElement("li");
		nodoEsplora.innerHTML = "<a href='./esplora.php'>Esplora</a>"
		breadcrumb.appendChild(nodoEsplora);
	} else if (ultimaPagina.substr(23, 13) == 'biografia.php') {
		var nodoPresentazione = document.createElement("li");
		var nodoBiografia = document.createElement("li");
		var idpersona = parseInt(ultimaPagina.substr(45, ultimaPagina.length - 45));
		var persona;
		var dati = new FormData();
		dati.append("id", idpersona);
		$.ajax({
			url: "php/post_NomeCognome.php",
			type: "POST",
			data: dati,
			success: function (resJ) {persona = JSON.parse(resJ);},
			cache: false,
			contentType: false,
			processData: false,
			async: false
		});
		nodoPresentazione.innerHTML = "<a href='./presentazione.php?persona=" + idpersona + "'>Presentazione " + persona[0] + " " + persona[1] +"</a>";
		nodoBiografia.innerHTML = "<a href='./biografia.php?persona=" + idpersona + "'>Biografia " + persona[0] + " " + persona[1] +"</a>";
		breadcrumb.appendChild(nodoPresentazione);
		breadcrumb.appendChild(nodoBiografia);
	};
	var nodoViaggio = document.createElement("li");
	nodoViaggio.innerHTML = "Viaggio";
	breadcrumb.appendChild(nodoViaggio);
} else if (ultimaPagina.substr(0, 22) == 'http://localhost/aplm/') {
	var nodoHome = document.createElement("li");
	nodoHome.innerHTML = "<a href='./index.php'>Home</a>"
	breadcrumb.appendChild(nodoHome);
	if (ultimaPagina.substr(22, 17) == 'presentazione.php') {
		var nodoPresentazione = document.createElement("li");
		var idpersona = parseInt(ultimaPagina.substr(48, ultimaPagina.length - 48));
		var persona;
		var dati = new FormData();
		dati.append("id", idpersona);
		$.ajax({
			url: "php/post_NomeCognome.php",
			type: "POST",
			data: dati,
			success: function (resJ) {persona = JSON.parse(resJ);},
			cache: false,
			contentType: false,
			processData: false,
			async: false
		});
		nodoPresentazione.innerHTML = "<a href='./presentazione.php?persona=" + idpersona + "'>Presentazione " + persona[0] + " " + persona[1] +"</a>";
		breadcrumb.appendChild(nodoPresentazione);
	} else if (ultimaPagina.substr(22, 11) == 'esplora.php') {
		var nodoEsplora = document.createElement("li");
		nodoEsplora.innerHTML = "<a href='./esplora.php'>Esplora</a>"
		breadcrumb.appendChild(nodoEsplora);
	} else if (ultimaPagina.substr(22, 13) == 'biografia.php') {
		var nodoPresentazione = document.createElement("li");
		var nodoBiografia = document.createElement("li");
		var idpersona = parseInt(ultimaPagina.substr(44, ultimaPagina.length - 44));
		var persona;
		var dati = new FormData();
		dati.append("id", idpersona);
		$.ajax({
			url: "php/post_NomeCognome.php",
			type: "POST",
			data: dati,
			success: function (resJ) {persona = JSON.parse(resJ);},
			cache: false,
			contentType: false,
			processData: false,
			async: false
		});
		nodoPresentazione.innerHTML = "<a href='./presentazione.php?persona=" + idpersona + "'>Presentazione " + persona[0] + " " + persona[1] +"</a>";
		nodoBiografia.innerHTML = "<a href='./biografia.php?persona=" + idpersona + "'>Biografia " + persona[0] + " " + persona[1] +"</a>";
		breadcrumb.appendChild(nodoPresentazione);
		breadcrumb.appendChild(nodoBiografia);
	};
	var nodoViaggio = document.createElement("li");
	nodoViaggio.innerHTML = "Viaggio";
	breadcrumb.appendChild(nodoViaggio);
} else {
	var nodoHome = document.createElement("li");
		nodoHome.innerHTML = "Stai usando la modalità anonima o vieni da un sito esterno, non è possibile tracciare il tuo percorso: torna alla <a href='./index.php'>Home</a> "
		breadcrumb.appendChild(nodoHome);
};

// Crea un vettore per la linea e uno per i punti
var vettoreLinea = new ol.source.Vector();
var vettorePunti = new ol.source.Vector();

// Stili riusati
var riga = new ol.style.Stroke({ color: '#800000', width: 2	});
var riempimento = new ol.style.Fill({ color: 'rgba(255,255,255,0.5)' });

// Assegna centro e zoom della mappa
var centro, zoom;
switch (scala) {
	case 'Italia':  centro = ol.proj.fromLonLat([11.71, 44.35]); //Imola
					zoom = 6;
					break;
	case 'Fiandre': centro = ol.proj.fromLonLat([3.23, 50.16]); //Cambrai
					zoom = 6;
					break;
	case 'Europa':	centro = ol.proj.fromLonLat([8.6, 46.71]); //Wassen
					zoom = 5;
					break;
	default:		centro = ol.proj.fromLonLat([0, 0]);
					zoom = 0;
					break;
};

// Crea una mappa con una vista e i vettori
var map = new ol.Map({
	target: 'map',
	layers: [
		new ol.layer.Tile({
			source: new ol.source.OSM({url: 'http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png'}) //TROVARE MODO PER SOLO FISICO
		}),
		new ol.layer.Vector({
      		source: vettoreLinea,
			style: new ol.style.Style({
				stroke: riga
			})
		}),
		new ol.layer.Vector({
      		source: vettorePunti,
			style: new ol.style.Style({
				image: new ol.style.Circle({
					fill: riempimento,
					stroke: riga,
					radius: 4
				}),
				fill: riempimento,
				stroke: riga
			})
		})
	],
	view: new ol.View({
		center: centro,
		zoom: zoom
	})
});

// Array dei punti della linea
var res;
var dati = new FormData();
dati.append("id", idviaggio);
$.ajax({
	url: "php/post_Viaggio.php",
	type: "POST",
	data: dati,
	success: function (resJ) {res = JSON.parse(resJ);},
	cache: false,
	contentType: false,
	processData: false,
	async: false
});

// Crea gli array di coordinate
var coordinate = [];
var nomiLuoghi = [];
for (var i = 0; i < res.length; i++) {
	coordinate.push([res[i][0], res[i][1]]);
	nomiLuoghi.push(res[i][3]);
};

// Crea la linea e la aggiunge al vettore
var linea = new ol.geom.LineString(coordinate);
linea.transform('EPSG:4326', 'EPSG:3857');
var featureLinea = new ol.Feature({
    name: "LineaViaggio",
    geometry: linea
});
vettoreLinea.addFeature(featureLinea);

// Crea i punti e lo aggiunge li vettore - FARE UN VETTORE PER OGNI PUNTO?
var punti = new ol.geom.MultiPoint(coordinate); //TROVARE MODO PER LABEL
punti.transform('EPSG:4326', 'EPSG:3857');
var featurePunti = new ol.Feature({
    name: "tappeViaggio",
    geometry: punti,
});
vettorePunti.addFeature(featurePunti);
