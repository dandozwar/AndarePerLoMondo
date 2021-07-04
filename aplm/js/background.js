// Cambia lo sfondo ogni 20 secondi
var nodoSfondo = document.getElementsByTagName("html")[0];
var sfondoAttuale = 0;
var pathSfondi = ['./img/Background1.jpg', './img/Background2.jpg', './img/Background3.jpg'];

function change_bg() {
	sfondoAttuale = (sfondoAttuale + 1) % 3;
	nodoSfondo.style = 'background-image: url("' + pathSfondi[sfondoAttuale] + '");';
	setTimeout(change_bg, 20000);
};

window.onload = function(){setTimeout(change_bg, 20000);}
