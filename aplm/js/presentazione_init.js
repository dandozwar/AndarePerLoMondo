// Imposto il breadcrumb
var breadcrumb = document.getElementById("breadcrumb");
var nodoHome = document.createElement("li");
nodoHome.innerHTML = "<a href='./index.php'>Home</a>"
breadcrumb.appendChild(nodoHome);
var ultimaPagina = document.referrer
if (ultimaPagina.substr(23, 11) == 'esplora.php') {
	var nodoEsplora = document.createElement("li");
	nodoEsplora.innerHTML = "<a href='./esplora.php'>Esplora</a>"
	breadcrumb.appendChild(nodoEsplora);
} else if (ultimaPagina.substr(22, 11) == 'esplora.php') {
	var nodoEsplora = document.createElement("li");
	nodoEsplora.innerHTML = "<a href='./esplora.php'>Esplora</a>"
	breadcrumb.appendChild(nodoEsplora);
};
var nodoViaggio = document.createElement("li");
nodoViaggio.innerHTML = "Presentazione";
breadcrumb.appendChild(nodoViaggio);

// Elenco di 20 colori
var colori = ['#800000', '#3cb44b', '#911eb4', '#000075', '#e6194B', '#aaffc3', '#808000', '#42d4f4', '#fabed4', '#469990', '#f032e6', '#fffac8', '#9A632', '#4363d8', '#ffd8b1', '#bfef45', '#f58231', '#dcbeff', '#ffe119', '#000000'];

var idviaggio = document.getElementsByTagName("h2")[0].id.substring(1);
var res;
$.ajax({
	type: "POST",
	url: "php/mappa_Presentazione.php",
	data: {id: idviaggio},
	success: function (resJ) {res = JSON.parse(resJ);},
	async: false
});

// Crea la legenda dei viaggi visualizzati
var legenda = document.getElementById("viaggi");
legenda.innerHTML = "";
var pagine = "";
var dump = "";
var viaggio = "";
var citazione = "";
for (var v = 0; v < res.length; v++) {
	var dp_anno = get_Data(res[v][0][1], res[v][0][6], false);
	var df_anno = get_Data(res[v][0][2], res[v][0][7], false);
	if (dp_anno == df_anno) {
		viaggio = "<a href='./viaggio.php?viaggio=" + res[v][0][3] + "'>" + res[v][0][0] + "</a> (" + dp_anno + ")";
	} else {
		viaggio = "<a href='./viaggio.php?viaggio=" + res[v][0][3] + "'>" + res[v][0][0] + "</a> (" + dp_anno + "-" + df_anno + ")";
	};
	pagine = " " + res[v][0][5];
	if (res[v][0][5] == null) {
		pagine = "";
	};
	citazione = " [" + "<a href='#f"+ res[v][0][4] + "'>" + res[v][0][4] + "</a>" + pagine + "]. "
	dump = dump + "<li>" + viaggio + citazione + "<span style='color: " + colori[v%20] + "'>\u25A0</span>" + "</li>";
};
legenda.innerHTML = dump;

// Crea un vettore per la linea e uno per i punti
var vettoreLinea = new ol.source.Vector();
var vettorePunti = new ol.source.Vector();

// Crea gli array di coordinate
var coordinate = [];
var nomiLuoghi = [];
for (var v = 0; v < res.length; v++) {
	coordinate[v] = [];
	nomiLuoghi[v] = [];
	coordinate[v].push([res[v][1][0][0], res[v][1][0][1]]);
	nomiLuoghi[v].push(res[v][1][0][2]);
	for (var t = 0; t < res[v][1].length; t++) {
		coordinate[v].push([res[v][1][t][3], res[v][1][t][4]]);
		nomiLuoghi[v].push(res[v][1][t][5]);
	};
};

for (var v = 0; v < coordinate.length; v++) {
	// Array delle geometrie dei segmenti (punti lon-lat)
	var segmenti = [];  
	for (var l = 0; l < res[v][1].length; l++) {
		segmenti.push(new ol.geom.LineString([[res[v][1][l][0], res[v][1][l][1]], [res[v][1][l][3], res[v][1][l][4]]]));
	};
	// Crea la linea e la aggiunge al vettore
	var linea = new ol.geom.MultiLineString(segmenti);
	linea.transform('EPSG:4326', 'EPSG:3857');
	var featureLinea = new ol.Feature({
		name: "LineaViaggio",
		geometry: linea
	});
	// Applico lo stile alla linea
	var stileLinea = new ol.style.Style({
		stroke: new ol.style.Stroke({ color: colori[v%20], width: 2 }),
	});
	featureLinea.setStyle(stileLinea);
	vettoreLinea.addFeature(featureLinea);
	// Crea i punti e li aggiunge al vettore
	var punti = new ol.geom.MultiPoint(coordinate[v]);
	punti.transform('EPSG:4326', 'EPSG:3857');
	var featurePunti = new ol.Feature({
		name: "tappeViaggio" + v,
		geometry: punti
	});
	// Applico lo stile al punto
	var stilePunti = new ol.style.Style({
		image: new ol.style.Circle({
			fill: new ol.style.Fill({ color: 'rgba(255,255,255,0.5)' }),
			stroke: new ol.style.Stroke({ color: colori[v%20], width: 2 }),
			radius: 4
		}),
		fill: new ol.style.Fill({ color: 'rgba(255,255,255,0.5)' }),
		stroke: new ol.style.Stroke({ color: colori[v%20], width: 2 })
	});
	featurePunti.setStyle(stilePunti);
	vettorePunti.addFeature(featurePunti);
};
// Scala
var scala = new ol.control.ScaleLine({
	bar: true,
	steps: 2,
	text: true
});

// Crea la mappa
var map = new ol.Map({
	target: 'map',
	controls: ol.control.defaults().extend([scala]),
	layers: [
		new ol.layer.Tile({
			source: new ol.source.Stamen({
				layer: 'terrain-background'
			})
		}),
		new ol.layer.Vector({
	  		source: vettoreLinea
		}),
		new ol.layer.Vector({
			source: vettorePunti
		})
	],
	view: new ol.View({
		padding: [40, 40, 40, 40]
	})
});

// Assegna lo zoom e il centro (trovando tutti i luoghi)
var tuttiLuoghi = [], coord = [];
for (var v = 0; v < coordinate.length; v++) {
	for (var l = 0; l < coordinate[v].length; l++) {
		coord = coordinate[v][l];
		if (tuttiLuoghi.includes(coord) != -1) {
			tuttiLuoghi.push(coord);
		};
	};
};
var punti = new ol.geom.MultiPoint(tuttiLuoghi);
punti.transform('EPSG:4326', 'EPSG:3857');
map.getView().fit(punti);
