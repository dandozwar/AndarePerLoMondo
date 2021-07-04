<?php
	session_start();
	unset($_SESSION["nick"]);
	unset($_SESSION["pass"]);
	unset($_SESSION["time"]);
	session_destroy();
?>
