// Trova l'id del viaggio
var idviaggio = parseFloat(document.getElementById("idviaggio").innerHTML);

// Imposto il breadcrumb
var breadcrumb = document.getElementById("breadcrumb");
var http = "", ultimaPagina = "";
var ultimaUrl = document.referrer;
if (ultimaUrl.substr(0, 40) == 'https://andareperlomondo.labcd.unipi.it/') {
	http = "https";
} else if (ultimaUrl.substr(0, 39) == 'http://andareperlomondo.labcd.unipi.it/') {
	http = "http";
} else {
	http = "no";
};
if (http == "no") {
	var nodoHome = document.createElement("li");
	nodoHome.innerHTML = "Stai usando la modalità anonima o vieni da un sito esterno, non è possibile tracciare il tuo percorso: torna alla <a href='./index.php'>Home</a> "
	breadcrumb.appendChild(nodoHome);
} else {
	var nodoHome = document.createElement("li");
	nodoHome.innerHTML = "<a href='./index.php'>Home</a>";
	breadcrumb.appendChild(nodoHome); 
	if (http == "https") {
		if (ultimaUrl.substr(40, 17) == 'presentazione.php') {
			ultimaPagina = "presenta";
		} else if (ultimaUrl.substr(40, 11) == 'esplora.php') {
			ultimaPagina = "esplora";
		} else if (ultimaUrl.substr(40, 13) == 'biografia.php') {
			ultimaPagina = "bio";
		};
	} else if (http == "http") {
		if (ultimaUrl.substr(39, 17) == 'presentazione.php') {
			ultimaPagina = "presenta";
		} else if (ultimaUrl.substr(39, 11) == 'esplora.php') {
			ultimaPagina = "esplora";
		} else if (ultimaUrl.substr(39, 13) == 'biografia.php') {
			ultimaPagina = "bio";
		};
	};
	if (ultimaPagina == "presenta") {
		var nodoPresentazione = document.createElement("li");
		if (http == "https") {
			idpersona = parseInt(ultimaUrl.substr(66, ultimaUrl.length - 66));
		} else if (http == "http") {
			idpersona = parseInt(ultimaUrl.substr(65, ultimaUrl.length - 65));
		};
		var persona;
		$.ajax({
			type: "POST",
			url: "php/post_NomeCognome.php",
			data: {id: idpersona},
			success: function (resJ) {persona = JSON.parse(resJ);},
			async: false
		});
		nodoPresentazione.innerHTML = "<a href='./presentazione.php?persona=" + idpersona + "'>Presentazione " + persona[0] + " " + persona[1] +"</a>";
		breadcrumb.appendChild(nodoPresentazione);
	} else if (ultimaPagina == "esplora") {
		var nodoEsplora = document.createElement("li");
		nodoEsplora.innerHTML = "<a href='./esplora.php'>Esplora</a>"
		breadcrumb.appendChild(nodoEsplora);
	} else if (ultimaPagina == "bio") {
		var nodoPresentazione = document.createElement("li");
		var nodoBiografia = document.createElement("li");
		var idpersona = "";
		if (http == "https") {
			idpersona = parseInt(ultimaUrl.substr(62, ultimaUrl.length - 62));
		} else if (http == "http") {
			idpersona = parseInt(ultimaUrl.substr(61, ultimaUrl.length - 61));
		};
		var persona;
		$.ajax({
			type: "POST",
			url: "php/post_NomeCognome.php",
			data: {id: idpersona},
			success: function (resJ) {persona = JSON.parse(resJ);},
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
};

// Array dei punti della linea
var res;
$.ajax({
	type: "POST",
	url: "php/mappa_Viaggio.php",
	data: {id: idviaggio},
	success: function (resJ) {
		res = JSON.parse(resJ);
		// Crea un vettore per la linea e uno per i punti
		var vettoreLinea = new ol.source.Vector();
		var vettorePunti = new ol.source.Vector();
		// Stili riusati
		var riga = new ol.style.Stroke({ color: '#800000', width: 2	});
		var riempimento = new ol.style.Fill({ color: 'rgba(255,255,255,0.5)' });
		// Scala
		var scala = new ol.control.ScaleLine({
			bar: true,
			steps: 2,
			text: true
		});
		// Crea gli array di coordinate
		var coordinate = [];
		var nomiLuoghi = [];
		var coord = [], nomeL = "";
		for (var i = 0; i < res.length; i++) { //Controlla se il luogo esiste già e se non lo aggiunge
			coord = [res[i][0], res[i][1]];
			if (coordinate.includes(coord) != -1) {
				coordinate.push(coord);
			};
			nomeL = res[i][2];
			if (nomiLuoghi.includes(nomeL) != -1) {
				nomiLuoghi.push(nomeL);
			};
			coord = [res[i][3], res[i][4]];
			if (coordinate.includes(coord) != -1) {
				coordinate.push(coord);
			};
			nomeL = res[i][5];
			if (nomiLuoghi.includes(nomeL) != -1) {
				nomiLuoghi.push(nomeL);
			};
		};
		// Array delle geometrie dei segmenti (punti lon-lat)
		var segmenti = [];  
		for (var l = 0; l < res.length; l++) {
			segmenti.push(new ol.geom.LineString([[res[l][0], res[l][1]], [res[l][3], res[l][4]]]));
		};
		// Crea la linea e la aggiunge al vettore
		var linea = new ol.geom.MultiLineString(segmenti);
		linea.transform('EPSG:4326', 'EPSG:3857');
		var featureLinea = new ol.Feature({
			name: "LineaViaggio",
			geometry: linea
		});
		vettoreLinea.addFeature(featureLinea);
		// Crea i punti e lo aggiunge li vettore
		var punti = new ol.geom.MultiPoint(coordinate);
		punti.transform('EPSG:4326', 'EPSG:3857');
		var featurePunti = new ol.Feature({
			name: "tappeViaggio",
			geometry: punti,
		});
		vettorePunti.addFeature(featurePunti);
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
				padding: [40, 40, 40, 40]
			})
		});
		map.getView().fit(punti);
	},
	async: false
});
