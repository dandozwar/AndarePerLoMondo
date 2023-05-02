var mappe = new Array();
var lastOpenChild;

// Funzione che fa comparire il popover
function pop_hover(nodo) {
	if (lastOpenChild != undefined ) {
		pop_out(lastOpenChild, "open");
	};
	var nodoId = nodo.id;
	var nodoNum = nodoId.substr(0, nodoId.length-4);
	var nodoPopId = "pop_" + nodoId;
	var nodoPop = document.getElementById(nodoPopId);
	nodoPop.style.visibility = "visible";
	if ( (mappe.find(mappa => mappa == "map" + nodoNum)) == undefined && nodo.className == "popover_localita") {
		// Prende le coordinate
		var lat = parseFloat(document.getElementById("lat" + nodoNum).innerHTML);
		var lon = parseFloat(document.getElementById("lon" + nodoNum).innerHTML);
		// Crea il vettore
		var vettorePunti = new ol.source.Vector();
		// Stili riusati
		var riga = new ol.style.Stroke({ color: '#800000', width: 2	});
		var riempimento = new ol.style.Fill({ color: 'rgba(255,255,255,0.5)' });
		// Crea la mappa con vista e vettore
		var map = new ol.Map({
			target: "map" + nodoNum,
			layers: [
				new ol.layer.Tile({
					source: new ol.source.OSM({url: 'http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png'})
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
				center: ol.proj.fromLonLat([lon, lat]),
				zoom: 6
			})
		});
		// Crea la linea e la aggiunge al vettore
		var punto = new ol.geom.Point([lon, lat]);
		punto.transform('EPSG:4326', 'EPSG:3857');
		var featurePunto = new ol.Feature({
			name: "Localita",
			geometry: punto
		});
		vettorePunti.addFeature(featurePunto);
		mappe.push("map" + nodoNum);
	};
	lastOpenChild = nodoPop;
};

// Funzione che fa scomparire il popover
function pop_out(nodo, tipo = "x") {
	if (tipo == "x") {
		var nodoPop = nodo.parentNode;
		nodoPop.style.visibility = "hidden";
	} else if (tipo == "open") {
		nodo.style.visibility = "hidden";
	};
	lastOpenChild = undefined;
};
