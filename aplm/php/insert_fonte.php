<?php
	// Stabilisce una connessione con il database
	include '../service/secrecy_com.php';


	//Include le funzioni
	include 'functions_fonti.php';

	if (isset($_POST['autore'])) {
		$autore = $_POST['autore'];
	} else {
		$autore = null;
	};
	if (isset($_POST['titolo'])) {
		$titolo = $_POST['titolo'];
	} else {
		$titolo = null;
	};
	if (isset($_POST['curatore'])) {
		$curatore = $_POST['curatore'];
	} else {
		$curatore = null;
	};
	if (isset($_POST['luogo'])) {
		$luogo = $_POST['luogo'];
	} else {
		$luogo = null;
	};
	if (isset($_POST['editore'])) {
		$editore = $_POST['editore'];
	} else {
		$editore = null;
	};
	if (isset($_POST['anno'])) {
		$anno = $_POST['anno'];
	} else {
		$anno = null;
	};
	if (isset($_POST['titolo_volume'])) {
		$titolo_volume = $_POST['titolo_volume'];
	} else {
		$titolo_volume = null;
	};
	if (isset($_POST['pagine'])) {
		$pagine = $_POST['pagine'];
	} else {
		$pagine = null;
	};
	if (isset($_POST['titolo_rivista'])) {
		$titolo_rivista = $_POST['titolo_rivista'];
	} else {
		$titolo_rivista = null;
	};
	if (isset($_POST['numero'])) {
		$numero = $_POST['numero'];
	} else {
		$numero = null;
	};
	if (isset($_POST['nome_sito'])) {
		$nome_sito = $_POST['nome_sito'];
	} else {
		$nome_sito = null;
	};
	if (isset($_POST['url'])) {
		$url = $_POST['url'];
	} else {
		$url = null;
	};
	$user = $_POST['utente'];

	$q = $conn->prepare('INSERT INTO Fonte (autore, titolo, curatore, luogo, editore, anno, collana, titolo_volume, pagine, titolo_rivista, numero, nome_sito, url, schedatore) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
	$q->bind_param("ssssssssssssss", $autore, $titolo, $curatore, $luogo, $editore, $anno, $collana, $titolo_volume, $pagine, $titolo_rivista, $numero, $nome_sito, $url, $user);
	$q->execute();
	$q->free_result();
	
	$qf = $conn->query('SELECT * FROM Fonte WHERE id = (SELECT MAX(id) FROM Fonte WHERE schedatore = "'.$user.'")');
	$res = $qf->fetch_row();
	echo json_encode([$res[0], get_Fonte($res)]);
?>
