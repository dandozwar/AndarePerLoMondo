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
var dati = new FormData();
dati.append("id", idviaggio);
$.ajax({
	url: "php/post_Presentazione.php",
	type: "POST",
	data: dati,
	success: function (resJ) {res = JSON.parse(resJ);},
	cache: false,
	contentType: false,
	processData: false,
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
	var dp_anno = get_Data(res[v][0][1], true);
	var df_anno = get_Data(res[v][0][2], true);
	if (dp_anno == df_anno) {
		viaggio = "<a href='./viaggio.php?viaggio=" + res[v][0][3] + "'>" + res[v][0][0] + "</a> (" + get_Data(res[v][0][1], true) + ")";
	} else {
		viaggio = "<a href='./viaggio.php?viaggio=" + res[v][0][3] + "'>" + res[v][0][0] + "</a> (" + get_Data(res[v][0][1], true) + "-" + get_Data(res[v][0][2], true) + ")";
	};
	pagine = " " + res[v][0][5];
	if (res[v][0][5] == null) {
		pagine = "";
	};
	citazione = " [" + "<a href='#f"+ res[v][0][4] + "'>" + res[v][0][4] + "</a>" + pagine + "]. "
	dump = dump + "<li>" + viaggio + citazione + "<span style='color: " + colori[v%20] + "'>\u25A0</span>" + "</li>";
};
legenda.innerHTML = dump;

// Visualizza i viaggi sulla mappa
var map = document.getElementById("map");
map.innerHTML = "";

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
