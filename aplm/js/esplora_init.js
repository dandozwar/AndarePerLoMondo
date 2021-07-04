// Imposto il breadcrumb
var breadcrumb = document.getElementById("breadcrumb");
var nodoHome = document.createElement("li");
nodoHome.innerHTML = "<a href='./index.php'>Home</a>"
breadcrumb.appendChild(nodoHome);
var nodoViaggio = document.createElement("li");
nodoViaggio.innerHTML = "Esplora";
breadcrumb.appendChild(nodoViaggio);

// Crea una mappa con una vista
var map = new ol.Map({
	target: 'map',
	layers: [
		new ol.layer.Tile({
			source: new ol.source.OSM({url: 'http://a.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png'}) //TROVARE MODO PER SOLO FISICO
		})
	],
	view: new ol.View({
		center: ol.proj.fromLonLat([8.6, 46.71]), //Wassen
		zoom: 5
	})
});
