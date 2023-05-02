// Elenco di 20 colori
var colori = ['#800000', '#3cb44b', '#911eb4', '#000075', '#e6194B', '#aaffc3', '#808000', '#42d4f4', '#fabed4', '#469990', '#f032e6', '#fffac8', '#9A632', '#4363d8', '#ffd8b1', '#bfef45', '#f58231', '#dcbeff', '#ffe119', '#000000'];

// Ottengo i percorsi delle biografie
var res;
$.ajax({
	type: "POST",
	url: "php/mappa_Index.php",
	success: function (resJ) {res = JSON.parse(resJ);},
	async: false
});

// Crea la legenda delle biografie
var biog;
for (var b = 0; b < res.length; b++) {
	biog = document.getElementById("b" + res[b][0][0]);
	biog.innerHTML = biog.innerHTML + "Colore <span style='color: " + colori[b%20] + "'>\u25A0</span> ";
};

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
