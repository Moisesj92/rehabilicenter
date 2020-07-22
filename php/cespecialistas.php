<?php
// Conectar 
	include ("link.php");

	//tab Asignaciones
	if (isset($_POST["idConsulta_sel"]) && isset($_POST["sesionInicial_num"]) && isset($_POST["sesionFinal_num"]) && isset($_POST["idEspecialista1_sel"]) && isset($_POST["horario_sel"]) && isset($_POST["idPaciente_h"]) ) 
	{
		//recibir variable
		$idc 		= $_POST["idConsulta_sel"];
		$sInicial 	= $_POST["sesionInicial_num"];
		$sFinal 	= $_POST["sesionFinal_num"];
		$ide 		= $_POST["idEspecialista1_sel"];
		$horario 	= $_POST["horario_sel"];
		$idp 		= $_POST["idPaciente_h"];

		//evitar isercion SQL
		$idc = mysqli_real_escape_string($enlace, $idc);
		$sInicial = mysqli_real_escape_string($enlace, $sInicial);
		$sFinal = mysqli_real_escape_string($enlace, $sFinal);
		$ide = mysqli_real_escape_string($enlace, $ide);
		$horario = mysqli_real_escape_string($enlace, $horario);
		$idp = mysqli_real_escape_string($enlace, $idp);

		//consultas
			//prevenir la insercion de mas de 4 pacientes en 1 solo horario
				$consulta = "SELECT 
								COUNT(DISTINCT id_indicacion_fisioterapia) as limite
							FROM
								fisioterapias
							WHERE
								horario_fisioterapia like '%0" .$horario. ":00%'
							AND
								id_especialista = ".$ide." 
							AND
								id_estatus_fisioterapia = 2
							";
				$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de prevencio de mas de 4 pacientes en cada horario"); //header('location: ../pacientes.php')
				$row_cnt = mysqli_num_rows($resultado);
				$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

				if ($row["limite"] < 3) 
				{
					//Crear Fecha actual
					$ahora = date("Y-m-d H:i:s");
					//buscar las fisioterapias a actualizar
						$consulta = "SELECT
										c.id_fisioterapia,
										c.id_especialista,
										c.horario_fisioterapia
									FROM
										indicaciones a,
										indicaciones_fisioterapias b,
										fisioterapias c
									WHERE
										a.id_consulta = ".$idc."
									AND
										a.id_indicacion = b.id_indicacion
									AND
										b.id_indicacion_fisioterapia = c.id_indicacion_fisioterapia
									AND
										c.id_estatus_fisioterapia BETWEEN 1 AND 2
									AND
										c.sesion_fisioterapia BETWEEN ".$sInicial." AND ".$sFinal."
									AND
										c.horario_fisioterapia >= '".$ahora."'
									ORDER BY
										c.sesion_fisioterapia
									";

						$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las fisioterapias a modificar"); //header('location: ../pacientes.php')
						$row_cnt = mysqli_num_rows($resultado);
						
						if ($row_cnt >= 1)
						{
							while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) 
							{
								//Modificar Fecha
								$fecI = $row["horario_fisioterapia"];
								$fechaHoraReal = date_create($fecI); //fecha de la base de datos
								$fechaControl = date_create(date_format($fechaHoraReal,'Y-m-d')); //el dia a la media noche
								date_add($fechaControl, date_interval_create_from_date_string( ''.$horario.'hours'));

								$consulta = "UPDATE
												fisioterapias
											SET
												id_especialista = ".$ide.",
												horario_fisioterapia = '".date_format($fechaControl,'Y-m-d H:i:s')."',
												id_estatus_fisioterapia = 2
											WHERE
												id_fisioterapia = ".$row["id_fisioterapia"]."
											";
								mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar las fisioterapias");
							}

						}
						else
						{
							
							//Mensaje de finalización
							printf ("<script language=\"JavaScript\">
										alert(\"Parece que hay algun error en los datos, las fisioterapias no fueron actualizadas\");
										window.location = \"../especialistas.php?paciente_sel=%s&tabControl_h=3\"
									</script>",$idp);
							
						}

				//Mensaje de finalización					
					printf ("<script language=\"JavaScript\">
								alert(\"Las Fisioterapias Han sido asignadas con exito\");
								window.location = \"../especialistas.php?paciente_sel=%s&tabControl_h=3\"
							</script>",$idp);
					
				}
				else if ($row["limite"] >= 3)
				{
					printf ("<script language=\"JavaScript\">
								alert(\"Este especialista ya posee la cantidad maxima de pacientes permitida para este horario\");
								window.location = \"../especialistas.php?paciente_sel=%s&tabControl_h=3\"
							</script>",$idp);
				}
			
				
	}


	//Tab Nuevo Especialista
	else if (isset($_POST["identificacion_txt"]) && isset($_POST["telf_txt"]) && isset($_POST["nombre_txt"]) && isset($_POST["apellido_txt"]) && isset($_POST["correo_email"])) 
	{
	 	
	 	//recivir Variable
	 		$ide = $_POST["identificacion_txt"];
	 		$tlf = $_POST["telf_txt"];
			$nom = $_POST["nombre_txt"];
			$ape = $_POST["apellido_txt"];
			$cor = $_POST["correo_email"];

		//Probar que se reciben las variables
		//printf("%s--%s--%s--%s",$ide ,$nom ,$ape, $cor);

		//Evitar isercion SQL

			$ide = mysqli_real_escape_string($enlace, $ide);
			$tlf = mysqli_real_escape_string($enlace, $tlf);
			$nom = mysqli_real_escape_string($enlace, $nom);
			$ape = mysqli_real_escape_string($enlace, $ape);
			$cor = mysqli_real_escape_string($enlace, $cor);

		//consultas
			//Actualizar si la identificacion ya existe

			$consulta = "SELECT ci_especialista FROM especialistas WHERE ci_especialista = '".$ide."'";
			$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de prevención de duplicados de espacialistas"); //header('location: ../pacientes.php')
			$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

			if ($row['ci_especialista'] === $ide) 
			{
				$consulta = "UPDATE 
								especialistas
							SET
								nombre_especialista = '".$nom."',
								apellido_especialista = '".$ape."',
								telefono_especialista = '".$tlf."',
								email_especialista = '".$cor."'
							WHERE
								ci_especialista = ".$ide."
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar el especialista");

				//Mensaje de finalización
				printf ("<script language=\"JavaScript\">
							alert(\"El especialista con el numero de cedula %s fue actualizado\");
							window.location = \"../especialistas.php?tabControl_h=1&mostrar_h=true\"
						</script>", $ide);
			}
			else
			{
				$consulta = "INSERT INTO especialistas
											(ci_especialista,
											nombre_especialista,
											apellido_especialista,
											telefono_especialista,
											email_especialista)
							VALUES
											('".$ide."',
											'".$nom."',
											'".$ape."',
											'".$tlf."',
											'".$cor."')
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo registrar al nuevo especialista");

				//Mensaje de finalización
				printf ("<script language=\"JavaScript\">
							alert(\"El especialista %s %s fue registrado con exito\");
							window.location = \"../especialistas.php?tabControl_h=1&mostrar_h=true\"
						</script>", $nom, $ape);
			}


	} 
	else if (isset($_GET["id_eliminar"]))
	{
		//recivir Variable
	 		$ide = $_GET["id_eliminar"];

		//Probar que se reciben las variables
		//printf("%s--%s--%s--%s",$ide ,$nom ,$ape, $cor);

		//Evitar isercion SQL

			$ide = mysqli_real_escape_string($enlace, $ide);

		//consultas
			$consulta = "DELETE FROM especialistas WHERE id_especialista = ".$ide." "; 
			mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar al especialista");

		//Mensaje de finalización
			printf ("<script language=\"JavaScript\">
						alert(\"El especialista ha sido eliminado con exito\");
						window.location = \"../especialistas.php?tabControl_h=1&mostrar_h=true\"
					</script>");

	}
	else
	{
		printf ("<script language=\"JavaScript\">
					alert(\"No hay ninguna variable con la cual trabajar\");
					window.location = \"../especialistas.php\"
				 </script>");
	}



 ?>