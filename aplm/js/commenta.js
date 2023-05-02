function commenta() {
	var bottoneComm = document.getElementById("commenta");
	bottoneComm.setAttribute("hidden", "hidden");
	var comment_panel = document.getElementById("comment_panel");
	comment_panel.removeAttribute("hidden");
};

function conferma_commento(nodo, tipo) {
	var res;
	var idutente = nodo.id;
	var form = document.getElementById("comment_form");
	var dati = new FormData(form);
	dati.append("nick", idutente);
	if (tipo == 0) { // 0 = Biografia
		var idpersona = document.getElementsByTagName("h1")[0].id.substring(1);
		dati.append("persona", idpersona);
		$.ajax({
			type: "POST",
			url: "php/commenta_biografia.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == "Commento inserito.") {
					location.reload();
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	} else if (tipo == 1) { // 1 = Viaggio
		var idviaggio = document.getElementsByTagName("h2")[0].id.substring(1);
		dati.append("viaggio", idviaggio);
		$.ajax({
			type: "POST",
			url: "php/commenta_viaggio.php",
			data: dati,
			success: function (resJ) {
				alert(resJ);
				if (resJ == "Commento inserito.") {
					location.reload();
				};
			},
			processData: false,
			contentType: false,
			async: false
		});
	};
};

function stop_commento() {
	var bottoneComm = document.getElementById("commenta");
	bottoneComm.removeAttribute("hidden");
	var comment_panel = document.getElementById("comment_panel");
	comment_panel.setAttribute("hidden", "hidden");
};
