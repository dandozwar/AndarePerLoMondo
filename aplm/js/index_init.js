// Elenco di 20 colori
var colori = ['#800000', '#3cb44b', '#911eb4', '#000075', '#e6194B', '#aaffc3', '#808000', '#42d4f4', '#fabed4', '#469990', '#f032e6', '#fffac8', '#9A632', '#4363d8', '#ffd8b1', '#bfef45', '#f58231', '#dcbeff', '#ffe119', '#000000'];

// Ottengo i percorsi delle biografie
var res;
$.ajax({
	url: "php/post_Index.php",
	type: "POST",
	success: function (resJ) {res = JSON.parse(resJ);},
	cache: false,
	contentType: false,
	processData: false,
	async: false
});

// Crea la legenda delle biografie
var biog;
for (var b = 0; b < res.length; b++) {
	biog = document.getElementById("b" + res[b][0][0]);
	biog.innerHTML = biog.innerHTML + "Colore <span style='color: " + colori[b%20] + "'>\u25A0</span> ";
};

// Crea una mappa con vista
var vettoreLinea = new ol.source.Vector();
var vettorePunti = new ol.source.Vector();
var map = new ol.Map({
	target: 'map',
	layers: [
		new ol.layer.Tile({
			source: new ol.source.OSM({url: 'http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png'}) //TROVARE MODO PER SOLO FISICO
		}),
		new ol.layer.Vector({
	  		source: vettoreLinea
		}),
		new ol.layer.Vector({
			source: vettorePunti,
		})
	],
	view: new ol.View({
		center: ol.proj.fromLonLat([8.6, 46.71]), //Wassen
		zoom: 5
	})
});

// Crea gli array di coordinate
var coordinate = [];
var nomiLuoghi = [];
for (var v = 0; v < res.length; v++) {
	coordinate[v] = [];
	nomiLuoghi[v] = [];
	for (var t = 0; t < res[v][1].length; t++) {
		coordinate[v].push([res[v][1][t][0], res[v][1][t][1]]);
		nomiLuoghi[v].push(res[v][1][t][3]);
	};
};
for (var v = 0; v < coordinate.length; v++) {
	// Crea la linea e la aggiunge al vettore
	var linea = new ol.geom.LineString(coordinate[v]);
	linea.transform('EPSG:4326', 'EPSG:3857');
	var featureLinea = new ol.Feature({
		name: "LineaViaggio" + v,
		geometry: linea
	});
	// Applico lo stile alla linea
	var stileLinea = new ol.style.Style({
		stroke: new ol.style.Stroke({ color: colori[v%20], width: 2 }),
	});
	featureLinea.setStyle(stileLinea);
	vettoreLinea.addFeature(featureLinea);
	// Crea i punti e li aggiunge al vettore
	var punti = new ol.geom.MultiPoint(coordinate[v]); //TROVARE MODO PER LABEL
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
