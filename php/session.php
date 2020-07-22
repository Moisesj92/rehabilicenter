<?php 
	session_start ();
	
	if (!$_SESSION['autentificado']) {
		header("Location: php/salir.php");
	}
 ?>