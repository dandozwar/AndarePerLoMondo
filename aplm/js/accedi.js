function stop_accedi() {
	var access_panel = document.getElementById("access_panel");
	access_panel.setAttribute("hidden", "hidden");
};

function conferma_accesso() {
 	var res;
	var form = document.getElementById("log_in_form");
	var dati = new FormData(form);
	$.ajax({
		url: "php/post_accedi.php",
		type: "POST",
		data: dati,
		success: function (resJ) {
			alert(resJ);
			if (resJ.substr(0, 10) == "Bentornato") {
				location.reload();
			};
		},
		cache: false,
		contentType: false,
		processData: false,
		async: false
	});
};

function registrati() {
	var sign_up = document.getElementById("sign_up");
	sign_up.removeAttribute("hidden");
	var log_in = document.getElementById("log_in");
	log_in.setAttribute("hidden", "hidden");
};

function conferma_registrati() {
	var res;
	var form = document.getElementById("sign_up_form");
	var dati = new FormData(form);
	$.ajax({
		url: "php/post_registrati.php",
		type: "POST",
		data: dati,
		success: function (resJ) {
			alert(resJ);
			if (resJ.substr(0, 10) == "Operazione") {
				location.reload();
			};
		},
		cache: false,
		contentType: false,
		processData: false,
		async: false
	});
};

function accedi_registrati() {
	var access_panel = document.getElementById("access_panel");
	access_panel.removeAttribute("hidden");
	var sign_up = document.getElementById("sign_up");
	sign_up.setAttribute("hidden", "hidden");
	var log_in = document.getElementById("log_in");
	log_in.removeAttribute("hidden");
};

function esci() {
	$.post("php/post_esci.php", "", function (res) {
		location.reload();
	});
}
