<?php 
//conectar
	include ("link.php");
	




	//Tab Modulo Paciente - Tipo De Pago
	if (isset($_POST["nombreTdp_txt"]) && isset($_POST["descTdp_txt"])) 
	{
		//Recivir las variables
		$nomTdp = $_POST["nombreTdp_txt"];
		$desTdp = $_POST["descTdp_txt"];

		//Evitar Insercion SQL
		$nomTdp = mysqli_real_escape_string($enlace, $nomTdp);
		$desTdp = mysqli_real_escape_string($enlace, $desTdp);

		//Consultas
			
			if (isset($_POST["modificarTdp_h"]) && isset($_POST["idTdp_h"])) 
			{
				//Modificar
				//recibir Variables
				$mod = $_POST["modificarTdp_h"];
				$idTdp = $_POST["idTdp_h"];

				//Evitar Insercion SQL
				$mod = mysqli_real_escape_string($enlace, $mod);
				$idTdp = mysqli_real_escape_string($enlace, $idTdp);

				//Modificar Tipos de pagos
				$consulta = "UPDATE
								tipos_pagos
							SET
								nombre_tipo_pago = '".$nomTdp."',
								desc_tipo_pago = '".$desTdp."'
							WHERE
								id_tipo_pago = ".$idTdp."
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta para modificar los tipos de pagos");

				//Mesaje de Finailzación
				printf ("<script language=\"JavaScript\">
							alert(\"El Tipo de pago fue Actualizado con Exito\");
							window.location = \"../configuracion.php\"
						 </script>");
			}
			else if (isset($_POST["eliminarTdp_h"]) && isset($_POST["idTdp_h"]))
			{
				//Eliminar
				//recibir Variables
				$eli = $_POST["eliminarTdp_h"];
				$idTdp = $_POST["idTdp_h"];

				//Evitar Insercion SQL
				$eli = mysqli_real_escape_string($enlace, $eli);
				$idTdp = mysqli_real_escape_string($enlace, $idTdp);

				//Eliminar Tipos de pagos
				$consulta = "DELETE FROM 
								tipos_pagos
							WHERE
								id_tipo_pago = ".$idTdp." 
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta para eliminar los tipos de pagos");

				//Mesaje de Finailzación
				printf ("<script language=\"JavaScript\">
							alert(\"El Tipo de pago Fue Eliminado con exito\");
							window.location = \"../configuracion.php\"
						 </script>");

			}
			else
			{
				//Nuevo
				//Prevenir Duplicados de tipos de pagos
				$consulta = "SELECT
								nombre_tipo_pago 
							FROM
								tipos_pagos
							WHERE
								nombre_tipo_pago = '".$nomTdp."'
							";
				$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de prevencion de duplicados para los tipos de pagos"); //header('location: ../pacientes.php')
				$row_cnt = mysqli_num_rows($resultado);

				if ($row_cnt >= 1) 
				{
					printf ("<script language=\"JavaScript\">
								alert(\"Ups! Tenemos un Problema, El Tipo de pago %s ya se encuentra registrado\");
								window.location = \"../configuracion.php\"
							</script>", $nomTdp);
					exit(); // Detenemos la ejeucion del php
				}
				else
				{
					$consulta = "INSERT INTO tipos_pagos
									(nombre_tipo_pago,
									desc_tipo_pago)

								VALUES
									('".$nomTdp."',
									 '".$desTdp."')
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo Insertar EL nuevo Tipo de pago");		
				}
				//Mesaje de Finailzación
				printf ("<script language=\"JavaScript\">
							alert(\"El nuevo Tipo de pago Fue Registrado con exito\");
							window.location = \"../configuracion.php\"
						 </script>");

			}
	}
	//Tab Modulo Paciente - Farmaco
	else if (isset($_POST["complejoActivo_txt"]) && isset($_POST["nombreComercial_txt"]) && isset($_POST["descFarmaco_txt"]))
	{
		//Recivir las variables
		$complejoFar = $_POST["complejoActivo_txt"];
		$nombreFar = $_POST["nombreComercial_txt"];
		$desFar = $_POST["descFarmaco_txt"];


		//Evitar Insercion SQL
		$complejoFar = mysqli_real_escape_string($enlace, $complejoFar);
		$nombreFar = mysqli_real_escape_string($enlace, $nombreFar);
		$desFar = mysqli_real_escape_string($enlace, $desFar);

		//Consultas
			if (isset($_POST["modificarFar_h"]) && isset($_POST["idFar_h"])) 
			{
				//Modificar
				//Recibir Variables
				$mod = $_POST["modificarFar_h"];
				$idFar = $_POST["idFar_h"];

				//Evitar Insercion SQL
				$mod = mysqli_real_escape_string($enlace, $mod);
				$idFar = mysqli_real_escape_string($enlace, $idFar);

				//modificar Farmacos
				$consulta = "UPDATE 
								farmacos
							SET
								complejo_activo_farmaco = '".$complejoFar."',
								desc_farmaco = '".$desFar."',
								nombre_comercial_farmaco = '".$nombreFar."'
							WHERE
								id_farmaco = ".$idFar."
							";

				mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta para modificar los farmacos");

				//Mesaje de Finailzación
				printf ("<script language=\"JavaScript\">
							alert(\"El Farmaco fue Actualizado con Exito\");
							window.location = \"../configuracion.php\"
						 </script>");

			}
			else if (isset($_POST["eliminarFar_h"]) && isset($_POST["idFar_h"]))
			{
				//Eliminar
				//recibir Variables
				$eli = $_POST["eliminarFar_h"];
				$idFar = $_POST["idFar_h"];

				//Evitar Insercion SQL
				$eli = mysqli_real_escape_string($enlace, $eli);
				$idFar = mysqli_real_escape_string($enlace, $idFar);

				//Eliminar Tipos de pagos
				$consulta = "DELETE FROM 
								farmacos
							WHERE
								id_farmaco = ".$idFar." 
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta para eliminar los Farmacos");

				//Mesaje de Finailzación
				printf ("<script language=\"JavaScript\">
							alert(\"El farmaco Fue Eliminado con exito\");
							window.location = \"../configuracion.php\"
						 </script>");

			}
			else
			{
				//Nuevo
				$consulta = "SELECT 
								complejo_activo_farmaco 
							FROM 
								farmacos 
							WHERE 
								complejo_activo_farmaco = '".$complejoFar."' 
							";
				$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de prevencion de duplicados para los farmacos"); //header('location: ../pacientes.php')
				$row_cnt = mysqli_num_rows($resultado);
				if ($row_cnt >= 1) 
				{
					printf ("<script language=\"JavaScript\">
									alert(\"Ups! Tenemos un Problema, El Farmaco %s ya se encuentra registrado\");
									window.location = \"../configuracion.php\"
								</script>", $complejoFar);
						exit(); // Detenemos la ejeucion del php
				}
				else
				{
					$consulta = "INSERT INTO farmacos
									(complejo_activo_farmaco,
									desc_farmaco,
									nombre_comercial_farmaco)
								VALUES
									('".$complejoFar."',
									'".$desFar."',
									'".$nombreFar."')
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo Insertar eL nuevo Farmaco");		
				}
				//Mesaje de Finailzación
				printf ("<script language=\"JavaScript\">
							alert(\"El nuevo Farmaco Fue Registrado con exito\");
							window.location = \"../configuracion.php\"
						 </script>");
			}
	}
	else
	{
		printf ("<script language=\"JavaScript\">
					alert(\"No hay ninguna variable con la cual trabajar\");
					window.location = \"../configuracion.php\"
				 </script>");
	}



 ?>