<?php 
//1) Recibir Variables

	$id = $_POST["usuario_txt"];
	$pw = $_POST["password_pw"];

//2) Conectar 
	include ("link.php");	

//3) Selecionar los datos
	//Evitar isercion SQL
		$id = mysqli_real_escape_string($enlace, $id);
		$pw = mysqli_real_escape_string($enlace, $pw);
	
	$consulta = "SELECT 
					a.nombre_usuario, a.pw_usuario,
					b.nombre_permiso
				 FROM
					usuarios a,
					permisos b 
				 WHERE 
				 	a.nombre_usuario =  '".$id."'
				 	AND
				 	a.id_permiso = b.id_permiso
				";
	$resultado = mysqli_query ($enlace, $consulta) or die ("no se pudo ejecutar la consulta");
	$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

//4) Autenticacion

	if ($id === $row['nombre_usuario']  && $pw === $row['pw_usuario']) {
		//inicio la sesion
		session_start();

		//Declaro Variables de sesion
		$_SESSION['autentificado'] = true;
		$_SESSION['usuario'] = $row['nombre_usuario'];
		$_SESSION['permiso'] = $row['nombre_permiso'];

		mysqli_close ($enlace);

		//Redirecionar la aplicación
		header ("Location: ../home.php");

	} else {
		mysqli_close ($enlace);
		header ("Location: ../index.php");
	}
	

 ?>