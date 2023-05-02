// Elenco di 20 colori
var colori = ['#800000', '#3cb44b', '#911eb4', '#000075', '#e6194B', '#aaffc3', '#808000', '#42d4f4', '#fabed4', '#469990', '#f032e6', '#fffac8', '#9A632', '#4363d8', '#ffd8b1', '#bfef45', '#f58231', '#dcbeff', '#ffe119', '#000000'];

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
	],
	view: new ol.View({
		center: ol.proj.fromLonLat([8.6, 46.71]), //Wassen
		zoom: 5,
		padding: [40, 40, 40, 40]
	})
});

// abilitazione delle modifiche
var abilitato = document.getElementById("abilitato");

var user = new URLSearchParams(window.location.search).get('user');
var res;
$.ajax({
	type: "POST",
	url: "php/mappa_pagina_personale.php",
	data: {nick: user},
	success: function (resJ) {
		res = JSON.parse(resJ);
		// Crea la legenda dei viaggi visualizzati
		var legenda = document.getElementById("viaggi");
		legenda.innerHTML = "";
		if (res.length != 0) {
			var pagine = "";
			var dump = "";
			var viaggio = "";
			var citazione = "";
			var modifica = "";
			var elimina = "";
			for (var v = 0; v < res.length; v++) {
				var dp_anno = get_Data(res[v][0][2], res[v][0][3], true)
				var df_anno = get_Data(res[v][0][4], res[v][0][5], true)
				if (dp_anno == df_anno) {
					viaggio = "<a href='./viaggio.php?viaggio=" + res[v][0][0] + "'>" + res[v][0][1] + "</a> (" + dp_anno + ")";
				} else {
					viaggio = "<a href='./viaggio.php?viaggio=" + res[v][0][0] + "'>" + res[v][0][1] + "</a> (" + dp_anno + "-" + df_anno + ")";
				};
				if (res[v][0][7] == null) {
					pagine = "";
				} else {
					pagine = " " + res[v][0][7];
				};
				if (res[v][0][6] == null) {
					citazione = " [Senza fonte]";
				} else {
					citazione = " [" + "<a href='#f"+ res[v][0][6] + "'>" + res[v][0][6] + "</a>" + pagine + "]. ";
				};
				if (abilitato) {
					modifica = "<input class='interact' type='button' value='&#9998;' onclick='modifica_viaggio(" + res[v][0][0] + ")'/>";
					elimina = "<input class='interact' type='button' value='X' onclick='elimina_viaggio(" + res[v][0][0] + ")'/>";
					dump = dump + "<li>" + viaggio + citazione + "<span style='color: " + colori[v%20] + "'>\u25A0</span>" + modifica + elimina +"</li>";
				} else {
					dump = dump + "<li>" + viaggio + citazione + "<span style='color: " + colori[v%20] + "'>\u25A0</span></li>";
				};
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
				if (res[v][1].length != 0) {
					coordinate[v].push([res[v][1][0][0], res[v][1][0][1]]);
					nomiLuoghi[v].push(res[v][1][0][2]);
					for (var t = 0; t < res[v][1].length; t++) {
						coordinate[v].push([res[v][1][t][3], res[v][1][t][4]]);
						nomiLuoghi[v].push(res[v][1][t][5]);
					};
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
			// Gestisce la mappa
			var layerLinea = new ol.layer.Vector({ source: vettoreLinea	});
			var layerPunti = new ol.layer.Vector({ source: vettorePunti	});
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
			map.addLayer(layerLinea);
			map.addLayer(layerPunti);
			map.getView().fit(punti);
		} else {
			legenda.innerHTML = "Nessun viaggio inserito fin ora.";
		};
	},
	async: false
});
