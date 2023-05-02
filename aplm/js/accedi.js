function stop_accedi() {
	var access_panel = document.getElementById("access_panel");
	access_panel.setAttribute("hidden", "hidden");
};

function conferma_accesso() {
 	var res;
	var form = document.getElementById("log_in_form");
	var dati = new FormData(form);
	$.ajax({
		type: "POST",
		url: "php/accedi.php",
		data: dati,
		success: function (resJ) {
			alert(resJ);
			if (resJ.substr(0, 10) == "Bentornato") {
				location.reload();
			};
		},
		processData: false,
		contentType: false,
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
		type: "POST",
		url: "php/registrati.php",
		data: dati,
		success: function (resJ) {
			alert(resJ);
			if (resJ.substr(0, 10) == "Operazione") {
				location.reload();
			};
		},
		processData: false,
		contentType: false,
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
	$.post("php/esci.php", "", function (res) {
		location.reload();
	});
}
