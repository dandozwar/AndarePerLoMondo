// Imposto il breadcrumb
var breadcrumb = document.getElementById("breadcrumb");
var nodoHome = document.createElement("li");
nodoHome.innerHTML = "<a href='./index.php'>Home</a>"
breadcrumb.appendChild(nodoHome);
var nodoViaggio = document.createElement("li");
nodoViaggio.innerHTML = "Esplora";
breadcrumb.appendChild(nodoViaggio);

// Scala
var scala = new ol.control.ScaleLine({
	bar: true,
	steps: 2,
	text: true
});

// Crea una mappa con una vista
var map = new ol.Map({
	target: 'map',
	controls: ol.control.defaults().extend([scala]),
	layers: [
		new ol.layer.Tile({
			source: new ol.source.Stamen({
				layer: 'terrain-background'
			})
		})
	],
	view: new ol.View({
		center: ol.proj.fromLonLat([8.6, 46.71]), //Wassen
		zoom: 5
	})
});
