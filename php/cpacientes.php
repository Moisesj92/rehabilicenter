<?php 
	// Conectar 
	include ("link.php");


		//Tab paciente
		if (isset($_POST["identificacion_txt"]) && isset($_POST["nombre_txt"]) && isset($_POST["apellido_txt"]) && isset($_POST["edad_txt"]) && isset($_POST["telefono_txt"]) && isset($_POST["correo_email"]) && isset($_POST["tipodepago_sel"]) && isset($_POST["entidad_txt"]) && isset($_POST["documentodepago_txt"])) 
		{
		//Recibir Variables
			$ide = $_POST["identificacion_txt"];
			$nom = $_POST["nombre_txt"];
			$ape = $_POST["apellido_txt"];
			$eda = $_POST["edad_txt"];
			$tlf = $_POST["telefono_txt"];
			$cor = $_POST["correo_email"];
			$tdp = $_POST["tipodepago_sel"];
			$ent = $_POST["entidad_txt"];
			$ddp = $_POST["documentodepago_txt"];

		//Probar que se reciben las variables
		//printf("%s--%s--%s--%s--%s--%s--%s--%s--%s--%s",$ide ,$nom ,$ape ,$eda ,$tlf ,$cor ,$mot ,$tdp ,$ent ,$ddp);

		//Evitar isercion SQL

			$ide = mysqli_real_escape_string($enlace, $ide);
			$nom = mysqli_real_escape_string($enlace, $nom);
			$ape = mysqli_real_escape_string($enlace, $ape);
			$eda = mysqli_real_escape_string($enlace, $eda);
			$tlf = mysqli_real_escape_string($enlace, $tlf);
			$cor = mysqli_real_escape_string($enlace, $cor);
			$tdp = mysqli_real_escape_string($enlace, $tdp);
			$ent = mysqli_real_escape_string($enlace, $ent);
			$ddp = mysqli_real_escape_string($enlace, $ddp);

		//echo "<br>";
		//printf("%s--%s--%s--%s--%s--%s--%s--%s--%s--%s",$ide ,$nom ,$ape ,$eda ,$tlf ,$cor ,$mot ,$tdp ,$ent ,$ddp);

		//consultas
			
			//Evitar duplicados de pacientes
			$consulta = "SELECT ci_paciente FROM pacientes WHERE ci_paciente = ".$ide."";
			$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de prevención de duplicados de pacientes"); //header('location: ../pacientes.php')
			$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

			if (isset($_POST["modificarPaciente_h"])) 
			{

				$mod = $_POST["modificarPaciente_h"];
				$mod = mysqli_real_escape_string($enlace, $mod);

				if ($mod == true) 
				{
					$consulta = "UPDATE pacientes
								SET
									nombre_paciente = '".$nom."',
									apellido_paciente = '".$ape."',
									edad_paciente = '".$eda."',
									telefono_paciente = '".$tlf."',
									email_paciente = '".$cor."'
								WHERE
									ci_paciente = '".$ide."'
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar el paciente");

					printf ("<script language=\"JavaScript\">
								alert(\"El paciente con la cedula %s fue actualizado con exito\");
								window.location = \"../pacientes.php\"
							</script>", $ide);
					exit(); // Detenemos la ejeucion del php
				}
			}
			else if (isset($_POST["reingresarPaciente_h"]))
			{
				$rei = $_POST["reingresarPaciente_h"];
				$rei = mysqli_real_escape_string($enlace, $rei);

				$ahora = date("Y-m-d H:i:s");
				//Insertar datos de consulta
				$consulta = "INSERT INTO consultas
											(fecha_consulta,
											id_tipo_consulta,
											id_historial_medico)
							VALUES
											('".$ahora."',
											1,
											(SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente)
											)
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva consulta de reingreso");

				//Insertar Pagos
				$consulta = "INSERT INTO pagos
											(fecha_pago,
											id_tipo_pago,
											entidad_pago,
											desc_pago,
											id_historial_medico)
							VALUES
											('".$ahora."',
											'".$tdp."',
											'".$ent."',
											'".$ddp."',
											(SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente)
											)
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo registrar el pago del reingreso");
				

				//Actualizar estatus del paciente
				$consulta = "UPDATE 
									pacientes
								SET
									id_estatus = 1
								WHERE 
									ci_paciente = ".$ide."
								";
				mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar el estatus del paciente reingresado");

				//Mensaje de finalización
				printf ("<script language=\"JavaScript\">
								alert(\"El paciente %s %s fue reingresado con exito\");
								window.location = \"../pacientes.php\"
							</script>", $nom, $ape);
				exit(); // Detenemos la ejeucion del php
			}
			else
			{
				if ($row['ci_paciente'] == $ide) 
				{
					printf ("<script language=\"JavaScript\">
								alert(\"El paciente con la cedula %s ya está registrado\");
								window.location = \"../pacientes.php\"
							</script>", $ide);
					exit(); // Detenemos la ejeucion del php
				}
				else //Insertar Datos del paciente
				{
					$consulta = "INSERT INTO pacientes
											(ci_paciente,
											nombre_paciente,
											apellido_paciente,
											edad_paciente,
											telefono_paciente,
											email_paciente,
											id_estatus)
								VALUES
											('".$ide."',
											'".$nom."',
											'".$ape."',
											'".$eda."',
											'".$tlf."',
											'".$cor."',
											1)
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo registrar al nuevo paciente");
				}
			}

			
			//Crear Historial Medico
			//Evitar duplicados de historiales
			
			$consulta = "SELECT 
							a.fecha_creacion_historial_medico, 
							a.id_paciente,
							b.ci_paciente
						FROM 
							historiales_medicos a,
							pacientes b
						WHERE 
							a.id_paciente = b.id_paciente
						AND
							b.ci_paciente = '".$ide."'
						";
			$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de prevención de duplicados de historiales"); //header('location: ../pacientes.php')
			$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
			$ahora = date("Y-m-d H:i:s");
			if ($row['id_paciente'] == $ide) 
			{
				
				printf ("<script language=\"JavaScript\">
							alert(\"Ups! Tenemos un Problema, El paciente con el número de C.I: %s ya posee un Historial Medico\");
							window.location = \"../pacientes.php\"
						</script>", $ide);
				exit(); // Detenemos la ejeucion del php
			}
			else //Insertar datos del Historial medico
			{
				
				$consulta = "INSERT INTO historiales_medicos
											(fecha_creacion_historial_medico,
											id_paciente)
							VALUES
											('".$ahora."',
											(SELECT id_paciente FROM pacientes WHERE ci_paciente = '".$ide."')
											)
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo registrar el nuevo historial medico");


				//Insertar datos de consulta
				$consulta = "INSERT INTO consultas
											(fecha_consulta,
											id_tipo_consulta,
											id_historial_medico)
							VALUES
											('".$ahora."',
											1,
											(SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente)
											)
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva consulta");

				//Insertar Pagos
				$consulta = "INSERT INTO pagos
											(fecha_pago,
											id_tipo_pago,
											entidad_pago,
											desc_pago,
											id_historial_medico)
							VALUES
											('".$ahora."',
											'".$tdp."',
											'".$ent."',
											'".$ddp."',
											(SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente)
											)
							";
				mysqli_query ($enlace, $consulta) or die ("No se pudo registrar el pago");
				mysqli_close($enlace);
				//Mensaje de finalización
				printf ("<script language=\"JavaScript\">
								alert(\"El paciente %s %s fue registrado con exito\");
								window.location = \"../pacientes.php\"
							</script>", $nom, $ape);
			}
		}
		//Tab Consulta
		else if (isset($_POST["identificacion_h"]) && isset($_POST["informe_txt"]) && isset($_POST["examenFisico_txt"]) && isset($_POST["diagnostico_txt"]))
		{
			//Recibir Variables

				$ide = $_POST["identificacion_h"];
				$inf = $_POST["informe_txt"];
				$exa = $_POST["examenFisico_txt"];
				$dia = $_POST["diagnostico_txt"];
				$fec = $_POST["fechaConsulta_h"];
				$tpc = $_POST["tipoConsulta_h"];

				
				if (isset($_POST["fechaInicioArry"]) && isset($_POST["numeroSesionesArry"])) 
				{
					$fecArry = $_POST["fechaInicioArry"];
					$numSArry = $_POST["numeroSesionesArry"];

					$long = count($fecArry);

					for ($i=0; $i < $long; $i++) 
					{ 
						$fecArry[$i] = mysqli_real_escape_string($enlace, $fecArry[$i]);
						$numSArry[$i] = mysqli_real_escape_string($enlace, $numSArry[$i]);
					}

					//print_r($fecArry);
					//print_r($numSArry);
				}
				if (isset($_POST["examenesArry"])) 
				{
					$exaArry = $_POST["examenesArry"];

					$long = count($exaArry);
					
					for ($i=0; $i < $long; $i++) { 
						$exaArry[$i] = mysqli_real_escape_string($enlace, $exaArry[$i]);
				}

				//print_r($exaArry);
					
				}
				if (isset($_POST["complejoActivoArry"]) && isset($_POST["intervaloHArry"]) && isset($_POST["intervaloDArry"])) 
				{
					
					$comAArry = $_POST["complejoActivoArry"];
					$intHArry = $_POST["intervaloHArry"];
					$intDArry = $_POST["intervaloDArry"];

					$long = count($comAArry);
					
					for ($i=0; $i < $long; $i++) 
					{ 
						$comAArry[$i] = mysqli_real_escape_string($enlace, $comAArry[$i]);
						$intHArry[$i] = mysqli_real_escape_string($enlace, $intHArry[$i]);
						$intDArry[$i] = mysqli_real_escape_string($enlace, $intDArry[$i]);
					}

					//print_r($comAArry);
					//print_r($intHArry);
					//print_r($intDArry);
				}
				if (isset($_POST["modificarConsulta_h"])) 
				{
					$mod = $_POST["modificarConsulta_h"];
					$mod = mysqli_real_escape_string($enlace, $mod);

				}
				//Probar Las Variables
				//printf ("---%s---%s---%s---%s",$inf ,$exa ,$dia, $fec);

				//Evitar Insercion SQL
				$ide = mysqli_real_escape_string($enlace, $ide);
				$inf = mysqli_real_escape_string($enlace, $inf);
				$exa = mysqli_real_escape_string($enlace, $exa);
				$dia = mysqli_real_escape_string($enlace, $dia);
				$fec = mysqli_real_escape_string($enlace, $fec);
				$tpc = mysqli_real_escape_string($enlace, $tpc);
			
			
			

				//Probar las variables scape
				//printf ("---%s---%s---%s---%s",$inf ,$exa ,$dia, $fec);

			//Consultas

				//consulta el id de la consulta a modificar
				$consulta = "SELECT 
								id_consulta,
								fecha_consulta
							FROM 
								consultas 
							WHERE 
								id_historial_medico = (SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente)
							AND 
								fecha_consulta = '".$fec."'
							";
				$resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del id de la consulta"); //header('location: ../pacientes.php')
				$row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

				
				if ($tpc == 1) 
				{
					//actualizar datos de la consulta tipo diagnostico
					$consulta = "UPDATE 
									consultas
								SET
									desc_informe_medico = '".$inf."',
									desc_examen_fisico = '".$exa."',
									desc_diagnostico = '".$dia."'
								WHERE
									id_consulta = ".$row['id_consulta']."
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo registrar el informe de la consulta de diagnostico");
				}
				else if ($tpc == 2)
				{
					$fechaCCI = date_create($fec); //Fecha de la consulta
					$fechaCC = date_create( date_format($fechaCCI,'Y-m-d')); //fecha de la consulta a media noche
					$horas = date("H");//Cantidad de horas a añadir
					$minutos = date ("i");//Cantidad de minutos a añadir
					$segundos = date ("s");//Cantidad de degundos a añadir

					date_add($fechaCC, date_interval_create_from_date_string( ''.$horas.'hours'));
					date_add($fechaCC, date_interval_create_from_date_string( ''.$minutos.'minutes'));
					date_add($fechaCC, date_interval_create_from_date_string( ''.$segundos.'seconds'));

					//actualizar datos de la consulta tipo diagnostico
					$consulta = "UPDATE 
									consultas
								SET
									fecha_consulta = '".date_format($fechaCC,'Y-m-d H:i:s')."',
									desc_informe_medico = '".$inf."',
									desc_examen_fisico = '".$exa."',
									desc_diagnostico = '".$dia."'
								WHERE
									id_consulta = ".$row['id_consulta']."
								";

					mysqli_query ($enlace, $consulta) or die ("No se pudo registrar el informe de la consulta de control");
				}
				
				if ( isset($fecArry) || isset($exaArry) || isset($comAArry) )
				{
					if (isset($mod))
					{
						//Obtener Id de la indicacion
						$consulta = "SELECT
										*
									FROM 
										indicaciones
									WHERE 
										id_consulta =  ".$row['id_consulta']."
									";
						$resultado1 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del id de la consulta"); //header('location: ../pacientes.php')
						$row_cnt1 = mysqli_num_rows($resultado1);
						$row1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);
						//Si la indicacion no existe
						if ($row_cnt1 < 1) 
						{
							//Isertar Datos De Indicaciones
							$consulta = "INSERT INTO indicaciones
														(id_consulta)
										VALUES
														(".$row['id_consulta'].")
										";
							mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva indicacion");

							//Obtener Id de la indicacion
							$consulta = "SELECT
											*
										FROM 
											indicaciones
										WHERE 
											id_consulta =  ".$row['id_consulta']."
										";
							$resultado1 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del id de la consulta"); //header('location: ../pacientes.php')
							//$row_cnt1 = mysqli_num_rows($resultado1);
							$row1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);

							//Asignar valor a variable del id indicacion
							$idInd = $row1["id_indicacion"];
							
						}
						else
						{
							//Asignar valor a variable del id indicacion
							$idInd = $row1["id_indicacion"];
							//Asignar valor a variable de fecha 
							$consultaControl = date_create($row1["fecha_consulta_control"]);
						}
						
					}
					else
					{
						//Prevenir duplicados de indicaciones
						$consulta = "SELECT
										*
									FROM 
										indicaciones
									WHERE 
										id_consulta =  ".$row['id_consulta']."
									";
						$resultado1 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del id de la consulta"); //header('location: ../pacientes.php')
						$row1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC);

						if ($row1["id_consulta"] === $row["id_consulta"] ) 
						{
							printf ("<script language=\"JavaScript\">
										alert(\"Hubo un problema con la insercion de las indicaciones\");
										window.location = \"../pacientes.php\"
									</script>");
							exit(); // Detenemos la ejeucion del php
						}
						else
						{
							//Isertar Datos De Indicaciones
							$consulta = "INSERT INTO indicaciones
														(id_consulta)
										VALUES
														(".$row["id_consulta"].")
										";
							mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva indicacion");

						}
					}
				}
				else
				{
					$consulta = "UPDATE 
									pacientes
								SET
									id_estatus = 4
								WHERE 
									ci_paciente = '".$ide."'
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar el estatus del paciente sin tratamiento");
				}

			//Insertar Fisio Si existe
				if (isset($fecArry) && isset($numSArry)) 
				{
					// si es esta modificando y la indicacion ya existia
					if (isset($mod) && $row_cnt1 == 1) 
					{
						//Selecionar todas las fisioterapias que pertenecen a la indicacion existente
						$consulta = "SELECT
										a.id_fisioterapia
									FROM
										fisioterapias a,
										indicaciones_fisioterapias b
									WHERE
										a.id_indicacion_fisioterapia = b.id_indicacion_fisioterapia
									AND
										b.id_indicacion = ".$idInd."
									";
						$resultado2 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las fisioterapias a eliminar"); //header('location: ../pacientes.php')
						$row_cnt2 = mysqli_num_rows($resultado2);
						
						//Eliminar Fisioterapias
						if ($row_cnt2 >= 1)
						{
							while ($row2 = mysqli_fetch_array($resultado2, MYSQLI_ASSOC)) 
							{
								$consulta = "DELETE FROM fisioterapias WHERE id_fisioterapia = ".$row2['id_fisioterapia']." ";
								mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la fisioterapia para la modificacion Varias");
							}
						}
						
						//Eliminar Indicaciones de las Fisioterapias
						$consulta = "DELETE FROM indicaciones_fisioterapias WHERE id_indicacion = ".$idInd." ";
						mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion de las fisioterapias existentes");

						//Eliminar La consulta que vayan despues de la consulta actual
						$consulta = "SELECT
										id_consulta
									FROM
										consultas
									WHERE
										id_historial_medico = (SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente)
									AND
										fecha_consulta > '".$row['fecha_consulta']."'
									";
						$resultado3 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las consultas a eliminar"); //header('location: ../pacientes.php')
						$row_cnt3 = mysqli_num_rows($resultado3);
						if ($row_cnt3 >= 1)
						{
							while ($row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC)) 
							{			
								//Determinar si tiene Indicaciones
									//Obtener Id de la indicacion
									$consulta = "SELECT
													*
												FROM 
													indicaciones
												WHERE 
													id_consulta =  ".$row3['id_consulta']."
												";
									$resultado4 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del id de la consulta"); //header('location: ../pacientes.php')
									$row_cnt4 = mysqli_num_rows($resultado4);
									$row4 = mysqli_fetch_array($resultado4, MYSQLI_ASSOC);

									//Si la indicacion no existe
									if ($row_cnt4 < 1) 
									{
										//Eliminar Pago
										$consulta = "DELETE FROM 
														pagos
													WHERE
														fecha_pago = (SELECT fecha_consulta FROM consultas WHERE id_consulta = ".$row3['id_consulta']." )
													";
										mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar el pago de las consultas furturas que lo poseen");	

										//Eliminar Consulta de contro con fecha posterior
										$consulta = "DELETE FROM 
														consultas 
													WHERE 
														id_consulta = ".$row3['id_consulta']."
													";
										mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar toda aquella consulta que tenga una fecha mayor a la actual");

									}
									else
									{
										//Eliminar Fisioterapias
											//Determinar si tiene Fisioterapias
											$consulta = "SELECT
															a.id_fisioterapia
														FROM
															fisioterapias a,
															indicaciones_fisioterapias b
														WHERE
															a.id_indicacion_fisioterapia = b.id_indicacion_fisioterapia
														AND
															b.id_indicacion = ".$row4['id_indicacion']."
														";
											$resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las fisioterapias a eliminar"); //header('location: ../pacientes.php')
											$row_cnt5 = mysqli_num_rows($resultado5);
											
											//Eliminar Fisioterapias
											if ($row_cnt5 >= 1)
											{
												while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC)) 
												{
													$consulta = "DELETE FROM fisioterapias WHERE id_fisioterapia = ".$row5['id_fisioterapia']." ";
													mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la fisioterapia para la modificacion Varias");
												}

												//Eliminar Indicaciones de las Fisioterapias
												$consulta = "DELETE FROM indicaciones_fisioterapias WHERE id_indicacion = ".$row4['id_indicacion']." ";
												mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion de las fisioterapias existentes");
											}

										//Eliminar Examenes
											//Determinar si tiene Examenes
											$consulta = "SELECT id_examen FROM examenes WHERE id_indicacion = ".$row4['id_indicacion']."";
											$resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los examenes a eliminar"); //header('location: ../pacientes.php')
											$row_cnt5 = mysqli_num_rows($resultado5);
											
											//Eliminar Examenes	
											if($row_cnt5 >= 1)
											{
												while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC)) 
												{
													$consulta = "DELETE FROM examenes WHERE id_examen = ".$row5['id_examen']."";
													mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar el examen de las consultas de control con mayor fecha");
												}
											}
										//Eliminar indicaciones Farmacologicas
											//Determinar si tiene Indicaciones farmacologicas
											$consulta = "SELECT id_indicacion_farmacologica FROM indicaciones_farmacologicas where id_indicacion = ".$row4['id_indicacion']."";
											$resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicaciones farmacologicas a eliminar"); //header('location: ../pacientes.php')
											$row_cnt5 = mysqli_num_rows($resultado5);

											//Eliminar Indicaciones Farmacologicas
											if ($row_cnt5 >= 1)
											{
												while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC)) 
												{
													$consulta ="DELETE FROM indicaciones_farmacologicas WHERE id_indicacion_farmacologica = ".$row5['id_indicacion_farmacologica']."";
													mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion farmacologica de las consultas de control con mayor fecha");
												}

											}
									}
								//Eliminar Indicaciones
								$consulta = "DELETE FROM 
												indicaciones
											WHERE 
												id_consulta = ".$row3['id_consulta']."
											";
								mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion de consultas futuras");

								//Eliminar Pago
								$consulta = "DELETE FROM 
												pagos
											WHERE
												fecha_pago = (SELECT fecha_consulta FROM consultas WHERE id_consulta = ".$row3['id_consulta']." )
											";
								
								//Eliminar COnsultas
								$consulta = "DELETE FROM 
												consultas
											WHERE 
												id_consulta = ".$row3['id_consulta']."
											";
								mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion de consultas futuras");
							}
						}
					}

					$long = count($fecArry);

					for ($i=0; $i < $long ; $i++) 
						{
							$fechaInicial = date_create($fecArry[$i]);
							
							//Crear indicaciones de fisioterapia
							$consulta = "INSERT INTO indicaciones_fisioterapias
														(id_indicacion,
														fecha_inicio_fisioterapia,
														numero_sesiones)
										VALUES
														((SELECT id_indicacion FROM indicaciones WHERE id_consulta = ".$row['id_consulta']."),
														'".date_format($fechaInicial,'Y-m-d')."',
														".$numSArry[$i].")
										";
							mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva indicacion de fisioterapias");

							//Crear Fisioterapia Inicial
							$consulta = "INSERT INTO fisioterapias
														(horario_fisioterapia,
														sesion_fisioterapia,
														id_estatus_fisioterapia,
														id_indicacion_fisioterapia)
										VALUES
														('".date_format($fechaInicial, 'Y-m-d')."',
														1,
														1,
														(SELECT id_indicacion_fisioterapia FROM indicaciones_fisioterapias where id_indicacion = (SELECT id_indicacion FROM indicaciones WHERE id_consulta = ".$row['id_consulta'].")))
										";
							mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva fisioterapia");


							

							for ($j=1; $j < $numSArry[$i] ; $j++) 
							{ 
								date_add($fechaInicial, date_interval_create_from_date_string('1 days'));
			
								$controlFines = date_format($fechaInicial, 'D');
								$controlFeriados = date_format($fechaInicial, 'd-m');  
								if ($controlFines == "Sat" || $controlFines == "Sun") 
								{
									$j--;
								}
								else
								{
									//Crear Fisioterapia secundarias
									$consulta = "INSERT INTO fisioterapias
																(horario_fisioterapia,
																sesion_fisioterapia,
																id_estatus_fisioterapia,
																id_indicacion_fisioterapia)
												VALUES
																('".date_format($fechaInicial, 'Y-m-d')."',
																".($j+1).",
																1,
																(SELECT id_indicacion_fisioterapia FROM indicaciones_fisioterapias where id_indicacion = (SELECT id_indicacion FROM indicaciones WHERE id_consulta = ".$row['id_consulta'].")))
												";

									mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva fisioterapia");
								}

								
							}

							//Acutalizar fecha de consulta de control en indicaciones
							$consulta = "UPDATE 
											indicaciones
										SET
											fecha_consulta_control = '".date_format($fechaInicial, 'Y-m-d')."'
										WHERE
											id_consulta = ".$row['id_consulta']."
										";
							mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar la indicacion con fisioterapias");	

						}				
				
					//Crear Consulta de control
					$consulta = "INSERT INTO consultas
												(fecha_consulta,
												id_tipo_consulta,
												id_historial_medico)
								VALUES
												('".date_format($fechaInicial, 'Y-m-d')."',
												2,
												(SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente)
												)
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva consulta de control");

					//actualizar estatus del paciente
					$consulta = "UPDATE 
									pacientes
								SET
									id_estatus = 2
								WHERE 
									ci_paciente = '".$ide."'
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar el estatus del paciente con fisioterapias");

				}

			//Insertar Examen si existe
				if (isset($exaArry))
				{
					
					if (isset($fecArry)) 
					{
						$fisio = true; 
					}
					else
					{
						$fisio = false;
					}
					// si es esta modificando y la indicacion ya existia
					if (isset($mod) && $row_cnt1 == 1) 
					{
							//Seleccionar todos los examenes pertenecientes a la indicacion actual
							$consulta = "SELECT id_examen FROM examenes WHERE id_indicacion = ".$idInd."  ";
							$resultado2 = mysqli_query ($enlace, $consulta) or die ("No se pudo consultar los examenes a eliminar de la indicacion actual");
							$row_cnt2 = mysqli_num_rows($resultado2);

							if ($row_cnt2 >= 1)
							{
								while ($row2 = mysqli_fetch_array($resultado2, MYSQLI_ASSOC)) 
								{
									$consulta = "DELETE FROM examenes WHERE id_examen = ".$row2['id_examen']." ";
									mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar el examen de la indicacion actual");
								}

							}

							if ($fisio == false) 
							{
								//Eliminar La consulta de control que vayan despues de la consulta actual
								$consulta = "SELECT
												id_consulta
											FROM
												consultas
											WHERE
												id_historial_medico = (SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente )
											AND
												fecha_consulta > '".$row['fecha_consulta']."'
											";
								$resultado3 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las consultas a eliminar"); //header('location: ../pacientes.php')
								$row_cnt3 = mysqli_num_rows($resultado3);
								if ($row_cnt3 >= 1)
								{
									while ($row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC)) 
									{			
										//Determinar si tiene Indicaciones
											//Obtener Id de la indicacion
											$consulta = "SELECT
															*
														FROM 
															indicaciones
														WHERE 
															id_consulta =  ".$row3['id_consulta']."
														";
											$resultado4 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del id de la consulta"); //header('location: ../pacientes.php')
											$row_cnt4 = mysqli_num_rows($resultado4);
											$row4 = mysqli_fetch_array($resultado4, MYSQLI_ASSOC);

											//Si la indicacion no existe
											if ($row_cnt4 < 1) 
											{
												//Eliminar Pago
												$consulta = "DELETE FROM 
																pagos
															WHERE
																fecha_pago = (SELECT fecha_consulta FROM consultas WHERE id_consulta = ".$row3['id_consulta']." )
															";
												mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar el pago de las consultas furturas que lo poseen");

												//Eliminar Consulta de contro con fecha posterior
												$consulta = "DELETE FROM 
																consultas 
															WHERE 
																id_consulta = ".$row3['id_consulta']."
															";
												mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar toda aquella consulta que tenga una fecha mayor a la actual");	

												
											}
											else
											{
												//Eliminar Fisioterapias
													//Determinar si tiene Fisioterapias
													$consulta = "SELECT
																	id_fisioterapia
																FROM
																	indicaciones_fisioterapias
																WHERE
																	id_indicacion = ".$row4['id_indicacion']."
																";
													$resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las fisioterapias a eliminar"); //header('location: ../pacientes.php')
													$row_cnt5 = mysqli_num_rows($resultado5);
													
													//Eliminar Fisioterapias
													if ($row_cnt5 >= 1)
													{
														while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC)) 
														{
															$consulta = "DELETE FROM fisioterapias WHERE id_fisioterapia = ".$row5['id_fisioterapia']." ";
															mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la fisioterapia para la modificacion Varias");
														}

														//Eliminar Indicaciones de las Fisioterapias
														$consulta = "DELETE FROM indicaciones_fisioterapias WHERE id_indicacion = ".$row4['id_indicacion']." ";
														mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion de las fisioterapias existentes");
													}

												//Eliminar Examenes
													//Determinar si tiene Examenes
													$consulta = "SELECT id_examen FROM examenes WHERE id_indicacion = ".$row4['id_indicacion']."";
													$resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los examenes a eliminar"); //header('location: ../pacientes.php')
													$row_cnt5 = mysqli_num_rows($resultado5);
													
													//Eliminar Examenes	
													if($row_cnt5 >= 1)
													{
														while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC)) 
														{
															$consulta = "DELETE FROM examenes WHERE id_examen = ".$row5['id_examen']."";
															mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar el examen de las consultas de control con mayor fecha");
														}
													}
												//Eliminar indicaciones Farmacologicas
													//Determinar si tiene Indicaciones farmacologicas
													$consulta = "SELECT id_indicacion_farmacologica FROM indicaciones_farmacologicas where id_indicacion = ".$row4['id_indicacion']."";
													$resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicaciones farmacologicas a eliminar"); //header('location: ../pacientes.php')
													$row_cnt5 = mysqli_num_rows($resultado5);

													//Eliminar Indicaciones Farmacologicas
													if ($row_cnt5 >= 1)
													{
														while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC)) 
														{
															$consulta ="DELETE FROM indicaciones_farmacologicas WHERE id_indicacion_farmacologica = ".$row5['id_indicacion_farmacologica']."";
															mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion farmacologica de las consultas de control con mayor fecha");
														}

													}
							
											}
										//Eliminar Indicaciones
										$consulta = "DELETE FROM 
														indicaciones
													WHERE 
														id_consulta = ".$row3['id_consulta']."
													";
										mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion de consultas futuras");

										//Eliminar Pago
										$consulta = "DELETE FROM 
														pagos
													WHERE
														fecha_pago = (SELECT fecha_consulta FROM consultas WHERE id_consulta = ".$row3['id_consulta']." )
													";
										mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar el pago de las consultas furturas que lo poseen");

										//Eliminar COnsultas
										$consulta = "DELETE FROM 
														consultas
													WHERE 
														id_consulta = ".$row3['id_consulta']."
													";
										mysqli_query ($enlace, $consulta) or die ("No se pudo eliminar la indicacion de consultas futuras");
									}
								}
							}

							
					}

					$long = count($exaArry);

					for ($i=0; $i < $long; $i++) 
						{

							$consulta = "INSERT INTO
											examenes(
												id_indicacion,
												nombre_examen)
										VALUES
											((SELECT id_indicacion FROM indicaciones WHERE id_consulta = ".$row['id_consulta']." ),
											'".$exaArry[$i]."')
										";
							mysqli_query ($enlace, $consulta) or die ("No se pudo registrar el arreglo de examenes");

							if ($fisio == false) 
							{

								$fechaInicial = date_create();


								for ($j=0; $j < 5 ; $j++) 
								{ 
									date_add($fechaInicial, date_interval_create_from_date_string('1 days')); 
									$controlFines = date_format($fechaInicial, 'D');
									$controlFeriados = date_format($fechaInicial, 'd-m');  
									if ($controlFines == "Sat" || $controlFines == "Sun") 
									{
										$j--;
									}
								}

								//Actualizar Fecha de consulta de control en indicaciones
									$consulta = "UPDATE 
													indicaciones
												SET
													fecha_consulta_control = '".date_format($fechaInicial, 'Y-m-d')."'
												WHERE
													id_consulta = ".$row['id_consulta']."
												";
									mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar la indicacion con examenes");

								//Crear Consulta de control
									$consulta = "INSERT INTO consultas
																(fecha_consulta,
																id_tipo_consulta,
																id_historial_medico)
												VALUES
																('".date_format($fechaInicial, 'Y-m-d')."',
																2,
																(SELECT a.id_historial_medico FROM historiales_medicos a, pacientes b WHERE b.ci_paciente = '".$ide."' AND a.id_paciente = b.id_paciente )
																)
												";
									mysqli_query ($enlace, $consulta) or die ("No se pudo registrar la nueva consulta de control para los examenes");
							}
						}

					//actualizar estatus del paciente
					$consulta = "UPDATE 
									pacientes
								SET
									id_estatus = 2
								WHERE 
									ci_paciente = '".$ide."'
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar el estatus del paciente con fisioterapias");
					
				}

			//Isertar Farmaco si existe
				if (isset($comAArry) && isset($intHArry) && isset($intDArry)) 
				{

					// si es esta modificando y la indicacion ya existia
					if (isset($mod) && $row_cnt1 == 1) 
					{
						//Seleccionar todas las indicaciones farmacologicas que pertenezcan a la indicacion actual
						$consulta ="SELECT id_indicacion_farmacologica FROM indicaciones_farmacologicas WHERE id_indicacion = ".$idInd." ";
						$resultado2 = mysqli_query($enlace, $consulta) or die ("No se pudo consultar las indicaciones farmacologicas de la indicacion actual");
						$row_cnt2 = mysqli_num_rows($resultado2);

						if ($row_cnt2 >= 1)
						{
							while ($row2 = mysqli_fetch_array($resultado2, MYSQLI_ASSOC)) 
							{
								$consulta = "DELETE FROM indicaciones_farmacologicas WHERE id_indicacion_farmacologica = ".$row2['id_indicacion_farmacologica']." ";
								mysqli_query($enlace, $consulta) or die ("No se pudo eliminar la indicaicones farmacologicas de la indicacion actual");
							}

						}
					}	

					$long = count($comAArry);

					for ($i=0; $i < $long; $i++) 
					{ 
						$consulta = "INSERT INTO
										indicaciones_farmacologicas(
											id_indicacion,
											id_farmaco,
											intervalo_horas,
											duracion)
									VALUES 
										((SELECT id_indicacion FROM indicaciones WHERE id_consulta = ".$row['id_consulta']."),
										(SELECT id_farmaco FROM farmacos WHERE complejo_activo_farmaco = '".$comAArry[$i]."'),
										".$intHArry[$i].",
										".$intDArry[$i].")
									";
						mysqli_query ($enlace, $consulta) or die ("No se pudo registrar el arreglo de Farmacos");

					}

					//actualizar estatus del paciente
					$consulta = "UPDATE 
									pacientes
								SET
									id_estatus = 2
								WHERE 
									ci_paciente = '".$ide."'
								";
					mysqli_query ($enlace, $consulta) or die ("No se pudo actualizar el estatus del paciente");
				}
			
			printf ("<script language=\"JavaScript\">
								alert(\"La consulta del paciente %s ha sido finalizada con exito\");
								window.location = \"../pacientes.php\"
							</script>", $ide);
		}
		else
		{
			printf ("<script language=\"JavaScript\">
						alert(\"No hay ninguna variable con la cual trabajar\");
						window.location = \"../pacientes.php\"
					 </script>");
		}

 ?>