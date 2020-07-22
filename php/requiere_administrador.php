<?php
	session_start();
	if ( (string) $_SESSION['permiso'] != 'Administrador') 
	{
		header("Location: principal.php?noautorizado=true");
	}
 ?>