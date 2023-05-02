// BREADCRUMB E USCITA SENZA CONFERMA /////////////////////////////////////////
var campo = new URLSearchParams(window.location.search).get('campo');
if (campo != null) {
	// breadcrumb
	var breadcrumb = document.getElementById('breadcrumb');
	switch (campo) {
		case 'ti':
			campo = 'titolo';
			break;
		case 'lp':
			campo = 'luogo partenza';
			break;
		case 'lm':
			campo = 'luogo meta';
			break;
		case 'dp':
			campo = 'data partenza';
			break;
		case 'df':
			campo = 'data fine';
			break;
		case 'pi':
			campo = 'piano';
			break;
		case 'fo':
			campo = 'fonte';
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

// TAPPE //////////////////////////////////////////////////////////////////////
if (document.getElementById('map') != null) {
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
				source: new ol.source.OSM({
					url: 'http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png'
				})
			}),
		],
		view: new ol.View({
			center: ol.proj.fromLonLat([8.6, 46.71]), //Wassen
			zoom: 5,
			padding: [40, 40, 40, 40]
		})
	});
	var idViaggio = new URLSearchParams(window.location.search).get('id');
	var dati = new FormData();
	var res;
	$.ajax({
			type: "POST",
			url: "php/mappa_Viaggio.php",
			data: {id: idViaggio},
			success: function (resJ) {
				res = JSON.parse(resJ);
				if (res.length != 0) {
					// Crea un vettore per la linea e uno per i punti
					var vettoreLinea = new ol.source.Vector();
					var vettorePunti = new ol.source.Vector();
					// Stili riusati
					var riga = new ol.style.Stroke({ color: '#800000', width: 2	});
					var riempimento = new ol.style.Fill({ color: 'rgba(255,255,255,0.5)' });
					// Crea gli array di coordinate
					var coordinate = [];
					var nomiLuoghi = [];
					var coord = [], nomeL = "";
					for (var i = 0; i < res.length; i++) { // Controlla se il luogo esiste già
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
					// Aggiorna la mappa
					var layerLinea = new ol.layer.Vector({
						source: vettoreLinea,
							style: new ol.style.Style({
							stroke: riga
						})
					});
					var layerPunti = new ol.layer.Vector({
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
					});
					map.addLayer(layerLinea);
					map.addLayer(layerPunti);
					map.getView().fit(punti);
				};
			},
			async: false
		});
	
};
