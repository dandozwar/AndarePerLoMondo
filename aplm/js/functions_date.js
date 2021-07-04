// Funzione di gestione della data
function get_Data (data, anno) {
	if (anno) {
		data = parseInt(data.substr(0, 4));
	} else {
		if (data.substr(5, 5) == '00-00') {
			data = parseInt(data.substr(0, 4));
		} else if (data.substr(8, 2) == '00') {
			mese = parseInt(data.substr(6, 2));
			mese = char_mese(mese);
			data = mese + ' ' + parseInt(data.substr(0, 4));
		} else {
			mese = parseInt(data.substr(6, 2));
			mese = char_mese(mese);
			data = parseInt(data.substr(8, 2)) + ' ' + mese + ' ' + parseInt(data.substr(0, 4));
		};
	};
	return data;
};

// Funzione che trasforma il mese da numero a caratteri
function char_mese(m) {
	mesi = ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'];
	switch (m) {
		case 1: return mesi[0];
		case 2: return mesi[1];
		case 3: return mesi[2];
		case 4: return mesi[3];
		case 5: return mesi[4];
		case 6: return mesi[5];
		case 7: return mesi[6];
		case 8: return mesi[7];
		case 9: return mesi[8];
		case 10: return mesi[9];
		case 11: return mesi[10];
		case 12: return mesi[11];
		default: return 'Errore';
	};
};
