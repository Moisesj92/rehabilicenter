<?php
//Insertar Paginas necesarias 
require("php/session.php");

//Codigo Funcional de la pag entera
    //conectar
    require("php/link.php");    

    //Modificar
    if (isset($_GET["modificar"])) 
    { 
        $mod = $_GET["modificar"];
        $mod = mysqli_real_escape_string($enlace, $mod);
        
        if (isset($_GET["tabControl_h"])) 
        {
            //Tab pacientes en modificar
            if ($_GET["tabControl_h"] == 1) 
            {

                $tabControl = $_GET["tabControl_h"];
                $idp = $_GET["id_paciente"];

                $tabControl = mysqli_real_escape_string($enlace, $tabControl);
                $idp = mysqli_real_escape_string($enlace, $idp);

                $consulta = "SELECT 
                                a.*,
                                c.*
                            FROM 
                                pacientes a,
                                historiales_medicos b,
                                pagos c
                            WHERE
                                a.id_paciente = b.id_paciente
                            AND
                                b.id_historial_medico = c.id_historial_medico
                            AND 
                                a.id_paciente = ".$idp." 
                            ";
                $resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del paciente"); //header('location: ../pacientes.php')
                $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);


                printf("<script language=\"JavaScript\">
                            var modificar = %s;
                            var tabControl = %s;
                            var valortdp = \"%s\";
                        </script>",$mod ,$tabControl, $row["id_tipo_pago"]);

            }
            //Tab consulta en modificar
            else if ($_GET["tabControl_h"] == 2) 
            {

                $idp = $_GET["id_paciente"];
                $idc = $_GET["id_consulta"];
                $tabControl = $_GET["tabControl_h"];

                //Prevenir Isercion sql
                $idp = mysqli_real_escape_string($enlace, $idp);
                $idc = mysqli_real_escape_string($enlace, $idc);
                $tabControl = mysqli_real_escape_string($enlace, $tabControl);
                //Selecionar la consulta
                $consulta = "SELECT
                                a.id_historial_medico,
                                b.ci_paciente,
                                b.nombre_paciente,
                                b.apellido_paciente,
                                b.edad_paciente,
                                b.id_estatus,
                                c.nombre_estatus_paciente,
                                c.desc_estatus_paciente,
                                d.id_consulta,
                                d.fecha_consulta,
                                d.desc_informe_medico,
                                d.desc_examen_fisico,
                                d.desc_diagnostico,
                                e.nombre_tipo_consulta,
                                d.id_tipo_consulta,
                                e.desc_tipo_consulta
                            FROM
                                historiales_medicos a,
                                pacientes b,
                                estatus_pacientes c,
                                consultas d,
                                tipos_consultas e
                            WHERE
                                b.id_paciente = ".$idp."
                            AND
                                d.id_consulta = ".$idc."
                            AND
                                a.id_paciente = b.id_paciente
                            AND
                                b.id_estatus = c.id_estatus_paciente
                            AND
                                a.id_historial_medico = d.id_historial_medico
                            AND
                                d.id_tipo_consulta = e.id_tipo_consulta
                                
                            ";
                $resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del paciente"); //header('location: ../pacientes.php')
                $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

                $ide = $row["ci_paciente"];

                //variables de control
                $pacienteExiste = true;
                printf("<script language=\"JavaScript\">
                        var pacienteExiste = true;
                        var pacienteEstatus = %s;
                        var fechaConsulta = new Date(\"%s\");
                    </script>", $row["id_estatus"], $row["fecha_consulta"]);

                    $consulta ="SELECT 
                            b.fecha_inicio_fisioterapia,
                            b.numero_sesiones
                        FROM
                            indicaciones a,
                            indicaciones_fisioterapias b
                        WHERE
                            a.id_consulta = ".$row['id_consulta']."
                        AND
                            a.id_indicacion = b.id_indicacion
                        ";
                    
                    $resultado2 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicacines de fisioterapia"); //header('location: ../pacientes.php')
                    $row_cnt2 = mysqli_num_rows($resultado2);
                    

                    $consulta ="SELECT 
                            c.nombre_examen
                        FROM
                            indicaciones a,
                            examenes c
                        WHERE
                            a.id_consulta = ".$row['id_consulta']."
                        AND
                            a.id_indicacion = c.id_indicacion
                        ";
                    $resultado3 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicacines de los examenes"); //header('location: ../pacientes.php')
                    $row_cnt3 = mysqli_num_rows($resultado3);

                    $consulta ="SELECT 
                            d.intervalo_horas,
                            d.duracion,
                            e.complejo_activo_farmaco
                        FROM
                            indicaciones a,
                            indicaciones_farmacologicas d,
                            farmacos e
                        WHERE
                            a.id_consulta = ".$row['id_consulta']."
                        AND
                            a.id_indicacion = d.id_indicacion
                        AND
                            d.id_farmaco = e.id_farmaco
                        ";
                    $resultado4 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicacines"); //header('location: ../pacientes.php')
                    $row_cnt4 = mysqli_num_rows($resultado4);

                printf("<script language=\"JavaScript\">
                                var modificar = %s;
                                var tabControl = %s;
                            </script>",$mod ,$tabControl);
                
            }
        }   
    }
    //Codigo de la tab Paciente
    $consulta = "SELECT
                    id_paciente,
                    ci_paciente,
                    nombre_paciente,
                    apellido_paciente
                FROM
                    pacientes
                WHERE
                    id_estatus = 4
                ";
    $resultado6 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de pacientes en alta"); //header('location: ../pacientes.php')
    $row_cnt6 = mysqli_num_rows($resultado6);

    if (isset($_GET["pacientesAlta_sel"]) && isset($_GET["tabControl_h"])) 
    {
        //recibir variable
        $idp = $_GET["pacientesAlta_sel"];
        $tabControl = $_GET["tabControl_h"];


        //Prevenir Insercion SQL
        $idp = mysqli_real_escape_string($enlace, $idp);
        $tabControl = mysqli_real_escape_string($enlace, $tabControl);

        //consulta
        $consulta = "SELECT * FROM pacientes WHERE id_paciente = ".$idp."";
        $resultado7 = mysqli_query($enlace, $consulta) or die ("No se pueden consultar los datos del paciente para el reingreso");
        $row_cnt7 = mysqli_num_rows($resultado7);
        $row7 = mysqli_fetch_array($resultado7, MYSQLI_ASSOC);

        printf("<script language=\"JavaScript\">
                    var reingreso = true;
                    var tabControl = %s;
                </script>",$tabControl);
    }



    //Codigo de la tab consulta
    if (isset($_GET["tabControl_h"]) && isset($_GET["identificacion1_txt"])) 
    {
        $ide = $_GET["identificacion1_txt"];
        $tabControl = $_GET["tabControl_h"];
        
        //variables de control
        $pacienteExiste = false;

        //Prevenir Isercion sql
        $ide = mysqli_real_escape_string($enlace, $ide);
        $tabControl = mysqli_real_escape_string($enlace, $tabControl);
        //Selecionar la ultima consulta a la que asistio
        $consulta = "SELECT a.id_historial_medico,
                            b.ci_paciente, 
                            b.nombre_paciente,
                            b.apellido_paciente,
                            b.edad_paciente,
                            b.id_estatus,
                            c.nombre_estatus_paciente,
                            c.desc_estatus_paciente,
                            d.id_consulta,
                            d.fecha_consulta,
                            d.desc_informe_medico,
                            d.desc_examen_fisico,
                            d.desc_diagnostico,
                            d.id_tipo_consulta,
                            e.nombre_tipo_consulta
                    FROM 
                        historiales_medicos a, 
                        pacientes b,
                        estatus_pacientes c,
                        consultas d,
                        tipos_consultas e
                    WHERE
                        a.id_paciente = b.id_paciente
                    AND
                        b.ci_paciente = '".$ide."'
                    AND
                        b.id_estatus = c.id_estatus_paciente
                    AND
                        a.id_historial_medico = d.id_historial_medico
                    AND
                        d.id_tipo_consulta = e.id_tipo_consulta
                    ORDER BY
                        d.fecha_consulta
                    DESC
                    limit 
                        1
                    ";
        $resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta del paciente"); //header('location: ../pacientes.php')
        $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);

        $consulta = "SELECT id_farmaco, complejo_activo_farmaco FROM farmacos";
        $resultado1 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los farmacos");

        if ($row["ci_paciente"] === $ide) 
        {
            $pacienteExiste = true;
            printf("<script language=\"JavaScript\">
                    var pacienteExiste = true;
                    var pacienteEstatus = %s;
                    var fechaConsulta = new Date(\"%s\");
                </script>", $row["id_estatus"], $row["fecha_consulta"]);

                $consulta ="SELECT 
                        b.fecha_inicio_fisioterapia,
                        b.numero_sesiones
                    FROM
                        indicaciones a,
                        indicaciones_fisioterapias b
                    WHERE
                        a.id_consulta = ".$row['id_consulta']."
                    AND
                        a.id_indicacion = b.id_indicacion
                    ";
                $resultado2 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicacines de fisioterapia"); //header('location: ../pacientes.php')
                $row_cnt2 = mysqli_num_rows($resultado2);

                $consulta ="SELECT 
                        c.nombre_examen
                    FROM
                        indicaciones a,
                        examenes c
                    WHERE
                        a.id_consulta = ".$row['id_consulta']."
                    AND
                        a.id_indicacion = c.id_indicacion
                    ";
                $resultado3 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicacines de los examenes"); //header('location: ../pacientes.php')
                $row_cnt3 = mysqli_num_rows($resultado3);

                $consulta ="SELECT 
                        d.intervalo_horas,
                        d.duracion,
                        e.complejo_activo_farmaco
                    FROM
                        indicaciones a,
                        indicaciones_farmacologicas d,
                        farmacos e
                    WHERE
                        a.id_consulta = ".$row['id_consulta']."
                    AND
                        a.id_indicacion = d.id_indicacion
                    AND
                        d.id_farmaco = e.id_farmaco
                    ";
                $resultado4 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las indicacines"); //header('location: ../pacientes.php')
                $row_cnt4 = mysqli_num_rows($resultado4);
        }
        else
        {
            printf("<script language=\"JavaScript\">
                    var pacienteExiste = false;
                </script>");   
        }

        //Funciones para mostrar el texto correctamente Usar en el printf
        //stripcslashes(nl2br(htmlentities($row['motivo_consulta'])));
        printf("<script language=\"JavaScript\">
                    var tabControl = %s;
                </script>",$tabControl);

    }

    //codigo de la tab Resumen
    if (isset($_GET["identificacion2_txt"]) && isset($_GET["tabControl_h"])) 
    {
        //recibir Variables
            $ide = $_GET["identificacion2_txt"];
            $tabControl = $_GET["tabControl_h"];

        //Evitar insercion sql
            $ide = mysqli_real_escape_string($enlace, $ide);
            $tabControl = mysqli_real_escape_string($enlace, $tabControl);

        //consulta

            $consulta = "SELECT
                        a.id_historial_medico,
                        a.fecha_creacion_historial_medico,
                        b.id_paciente,
                        b.ci_paciente,
                        b.nombre_paciente,
                        b.apellido_paciente
                    FROM
                        historiales_medicos a,
                        pacientes b
                    WHERE
                        b.ci_paciente = '".$ide."'
                    AND
                        a.id_paciente = b.id_paciente
                    ";
            $resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de pacientes"); //header('location: ../pacientes.php')
            $row_cnt5 = mysqli_num_rows($resultado5);


        //Redireccionar Tab
        printf("<script language=\"JavaScript\">
                    var tabControl = %s;
                </script>",$tabControl);


    }
    else
    {
        //consulta
        $consulta = "SELECT
                        a.id_historial_medico,
                        a.fecha_creacion_historial_medico,
                        b.id_paciente,
                        b.ci_paciente,
                        b.nombre_paciente,
                        b.apellido_paciente
                    FROM
                        historiales_medicos a,
                        pacientes b
                    WHERE
                        a.id_paciente = b.id_paciente
                    ";
        $resultado5 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de pacientes"); //header('location: ../pacientes.php')
        $row_cnt5 = mysqli_num_rows($resultado5);

    }
        

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<?php require("comunes/head.php"); ?>
	<!-- Custom CSS de Cada Pagina -->
    
	<title>Pacientes</title>
</head>
<body>
	<div id="wrapper">
		<!-- Sidebar -->
		<?php require("comunes/sidebar.php") ?>

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <!--Titulo identificador de la pagina --> 
            <div class="row">
            	<div class="col-xs-2 col-md-2">
            		<a href="#menu-toggle" class="btn btn-lg" id="menu-toggle"><span class="glyphicon glyphicon-menu-hamburger" aria-hidden="true"></span></a>
            	</div>
            	<div class="col-xs-8 col-md-4 col-md-offset-2">
            		<h2 class="text-center">Pacientes</h2>
                    <hr>
                        <p class = "active-tab"><strong>Active Tab</strong>: <span></span></p>
                        <p class = "previous-tab"><strong>Previous Tab</strong>: <span></span></p>
                    <hr>
            	</div>
                <div class="col-xs-2 col-md-2 col-md-offset-2">
                    <p class="text-right"> Info Usuario</p>
                </div>
            </div>
            
            <!--Menu selector de tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Principal</a></li>
                <li disabled><a data-toggle="tab" href="#menu1">Paciente</a></li>
                <li><a data-toggle="tab" href="#menu2">Consulta</a></li>
                <li><a data-toggle="tab" href="#menu3">Resumen</a></li>
            </ul>
            <!--Contenido Tabs-->
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                	<div class="row">
                		<div class="col-xs-12 col-md-8 col-md-offset-2">
                			<h3 class="text-center">Bienevido al Modulo de Pacientes</h3>
                			<p class="text-justify">En el modulo de pacientes se encuetran todas las acciones que se pueden realizar en base al paciente, te invito a que lo puebes y navegues por cada una de sus pestañas y descrubras todo lo que puedes hacer en el.</p>
                		</div>
                	</div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Nuevo Ingreso <small>Porfavor complete los datos del paciente</small></h3>
                    <div class="row">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Datos Generales</h4></div>
                                <div class="panel-body">
                                    <h4>Paciente</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <!-- Aqui empieza el formulario principal de la tab nuevo paciente -->

                                            <form id="idPacienteNuevo_frm" name="pacienteNuevo_frm" action="php/cpacientes.php" method="POST">
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-6">
                                                        <div id="divNombre" class="form-group">
                                                            <label for="nombre">Nómbre</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="nombre" name="nombre_txt" placeholder="Jose" maxlength="15" <?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("value = \"%s\" ",$row["nombre_paciente"]); }else if (isset($idp) && $tabControl == 1){ printf("value = \"%s\"",$row7["nombre_paciente"]); } ?>>
                                                                <div class="input-group-addon" data-toggle="tooltip" data-placement="right" title="Ejemplo: Perensejo"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <div id="divApellido" class="form-group">
                                                            <label for="apellido">Apellido</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="apellido" name="apellido_txt" placeholder="Perez" maxlength="15" <?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("value = \"%s\" ",$row["apellido_paciente"]); }else if (isset($idp) && $tabControl == 1){ printf("value = \"%s\"",$row7["apellido_paciente"]); } ?>>
                                                                <div class="input-group-addon" data-toggle="tooltip" data-placement="right" title="Ejemplo: Sultanejo"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-4">
                                                        <div id="divIdentificacion" class="form-group">
                                                            <label for="identificacion">Identificación</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="identificacion" name="identificacion_txt" placeholder="12555333" maxlength="10" <?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("value = %s ",$row["ci_paciente"]); }else if (isset($idp) && $tabControl == 1){ printf("value = \"%s\"",$row7["ci_paciente"]); } ?>>
                                                                <div class="input-group-addon" data-toggle="tooltip" data-placement="right" title="Ejemplo: 15555555"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-3">
                                                        <div id="divEdad" class="form-group">
                                                            <label for="edad">Edad</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="edad" name="edad_txt" placeholder="20" maxlength="2" <?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("value = %s ",$row["edad_paciente"]); }else if (isset($idp) && $tabControl == 1 ){ printf("value = \"%s\"",$row7["edad_paciente"]); } ?>>
                                                                <div class="input-group-addon" data-toggle="tooltip" data-placement="right" title="Ejemplo: 55"><span class="glyphicon glyphicon-calendar" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-5">
                                                        <div id="divTelefono" class="form-group">
                                                            <label for="telefono">Teléfono</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="telefono" name="telefono_txt" placeholder="0424-2552525" maxlength="14" <?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("value = %s ",$row["telefono_paciente"]); }else if (isset($idp) && $tabControl == 1){ printf("value = \"%s\"",$row7["telefono_paciente"]); } ?>>
                                                                <div class="input-group-addon" data-toggle="tooltip" data-placement="right" title="Ejemplo: 0555-5555555"><span class="glyphicon glyphicon-phone-alt" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-12">
                                                        <div id="divCorreo" class="form-group">
                                                            <label for="correo">Correo Electrónico</label>
                                                            <div class="input-group">
                                                                
                                                                <input type="email" class="form-control" id="correo" name="correo_email" placeholder="ejemplo@dominio.com" maxlength="70" <?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("value = \"%s\" ",$row["email_paciente"]); }else if (isset($idp) && $tabControl == 1){ printf("value = \"%s\"",$row7["email_paciente"]); } ?>>
                                                                <div class="input-group-addon" data-toggle="tooltip" data-placement="right" title="Ejemplo: ejemplo@servicio.com"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <h4>Pago</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-6">
                                                        <div id="divTipoDePago" class="form-group">
                                                            <label for="tipoDePago">Tipo de pago</label>
                                                            <select id="tipoDePago" class="form-control" name="tipodepago_sel">
                                                                <option value="0" disabled selected>Elija una forma de pago</option>
                                                                <?php  
                                                                    //Consultar datos
                                                                    $consulta = "SELECT id_tipo_pago, nombre_tipo_pago FROM tipos_pagos";
                                                                    $resultado8 = mysqli_query($enlace, $consulta) or die ("No se pueden consultar los datos de los tipos de pagos");
                                                                    $row_cnt8 = mysqli_num_rows($resultado8);
                                                                    while ($row8 = mysqli_fetch_array($resultado8, MYSQLI_ASSOC)) 
                                                                    {
                                                                        printf("<option value=\"%s\">%s</option>",$row8["id_tipo_pago"], $row8["nombre_tipo_pago"]);
                                                                    }
                                                                 ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <div id="divEntidad" class="form-group">
                                                            <label for="entidad">Entidad</label>
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" id="entidad" name="entidad_txt" placeholder="Entidad del pago" maxlength="30" <?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("value = \"%s\" ",$row["entidad_pago"]); } ?>>
                                                                <div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ejemplo: Banesco/Seguros Horizonte/Rehabilicenter"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-8 col-md-offset-2">
                                                        <div  id ="divDocumentoDePago" class="form-group">
                                                            <label for="documentoDePago">Descripción del pago</label>
                                                            <textarea class="form-control" rows="6" id="documentoDePago" name="documentodepago_txt" placeholder="Escriba aqui los datos del pago"><?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("%s ",$row["desc_pago"]); } ?></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- Aqui cierra el form particular  </form>-->
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-5 col-md-offset-1">
                                            <button type="reset" class="btn btn-default btn-block" form="idPacienteNuevo_frm">Limpiar Todo</button>
                                        </div>
                                        <div class="col-xs-6 col-md-5">
                                            <button id="enviarPacienteNuevo_frm" type="button" class="btn btn-default btn-block" form="idPacienteNuevo_frm"><?php if (isset($mod) && isset($idp) && $tabControl == 1) { printf("Modificar"); }else if (isset($idp) && $tabControl == 1) { printf("Reingresar"); }else{ printf("Agregar Nuevo"); } ?></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h3>Reingreso <small> Elige los pacientes que vuelven a tratamiento</small></h3>
                    <div class="row">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Reingresar paciente</h4></div>
                                <div class="panel-body">
                                    <h4>Paciente</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <form id ="idReingreso_frm" name="reingreso_frm" action="pacientes.php" method="GET">
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-10 col-md-offset-1">
                                                        <div id="divPacientesAlta" class="form-group">
                                                            <select id="pacientesAlta" class="form-control" name="pacientesAlta_sel">
                                                                <?php
                                                                    if ($row_cnt6 > 0) 
                                                                    {
                                                                        printf("<option value=\"0\" disabled selected>Elige un paciente para el reingreso</option>");
                                                                        while ($row6 = mysqli_fetch_array($resultado6, MYSQLI_ASSOC)) 
                                                                        {
                                                                            printf("<option value=\"%s\">%s - %s %s</option>", $row6["id_paciente"], $row6["ci_paciente"], $row6["nombre_paciente"], $row6["apellido_paciente"]);
                                                                        }    

                                                                    }
                                                                    else
                                                                    {
                                                                        printf(" <option value=\"0\" disabled selected>No Hay pacientes en alta</option> ");
                                                                    }  
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input  type="hidden" name="tabControl_h" value="1">
                                            </form>
                                        </div>
                                    </div> 
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                                            <button id="enviarReingreso_frm" type="button" class="btn btn-default btn-block" form="idReingreso_frm">Consultar</button>
                                        </div>
                                    </div>
                                </div>      
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu2" class="tab-pane fade ">
                    <h3>Consultas <small>Por favor complete los formularios de datos para las consulta</small> </h3>
                    <div class="row">
                        <div class="col-xs-12 col-md-3">
                            <div class="panel panel-rojo">
                                <div class="panel-heading">
                                    <h4 class="text-center">Buscar Paciente</h4>
                                </div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <!-- Formulario para buscar paciente para la nueva consulta -->
                                            <form id="idBuscarPaciente_frm" name="buscarPaciente_frm" action="pacientes.php" method="GET">
                                                <div id="divIdentificacion1" class="form-group">
                                                    <label for="identificacion1">Identificación</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="identificacion1" name="identificacion1_txt" placeholder="C.I." maxlength="10">
                                                        <div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ejemplo: 15555555" ><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                                                    </div>
                                                    <!-- <span class="glyphicon glyphicon-remove form-control-feedback"></span> -->
                                                </div>
                                                <input name="tabControl_h" type="hidden" value="2">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                                            <button id="enviarBuscarPaciente_frm" type="button" class="btn btn-default btn-block" form="idBuscarPaciente_frm">Buscar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <div class="panel panel-rojo">
                                <div class="panel-heading">
                                    <h4 class="text-center">Datos Del Paciente</h4>
                                </div>
                                <div class="panel-body">
                                    <?php 
                                    if (isset($pacienteExiste))
                                        {
                                            if ($pacienteExiste == true) 
                                            {

                                                //Crear variable de tipo date
                                                $fechaConsulta = date_create($row["fecha_consulta"]);
                                                //dar formato a variable creada
                                                $fechaConsultaF1 = date_format($fechaConsulta, 'd/m/Y');
                                                $fechaConsultaF2 = date_format($fechaConsulta, 'h:i:s A');

                                                printf("
                                                    <div class=\"row\">
                                                        <div class=\"col-xs-12 col-md-5 col-md-offset-1\">
                                                            <p><b>Nombre:</b> %s %s</p>
                                                            <p><b>Edad:</b> %s</p>
                                                        </div>
                                                        <div class=\"col-xs-12 col-md-5\">
                                                            <p class=\"text-right\"><b>Fecha Consulta:</b> %s</p>
                                                            <p class=\"text-right\"><b>Tipo de Consulta:</b> %s</p>
                                                        </div>
                                                    </div>
                                                    <div class=\"row\">
                                                        <div class=\"col-xs-12 col-md-10 col-md-offset-1\">
                                                            <p class=\"text-center\"><b>Estatus del paciente: %s</b></p>
                                                            <p class=\"text-justify\"> %s </p>
                                                        </div>
                                                    </div>

                                                    ",$row["nombre_paciente"], $row["apellido_paciente"], $row["edad_paciente"], $fechaConsultaF1, $row["nombre_tipo_consulta"], $row['nombre_estatus_paciente'], $row['desc_estatus_paciente'] );
                                            
                                            }
                                            else
                                            {
                                                printf("
                                                    <div class=\"row\">
                                                        <div class=\"col-xs-12 col-md-10 col-md-offset-1\">
                                                            <h4 class=\"text-center\">El paciente con el numero de cedula -- %s -- no esta registrado en la base de datos</h4>
                                                        </div>
                                                    </div>
                                                    <div class=\"row\">
                                                        <div class=\"col-xs-12 col-md-10 col-md-offset-1\">
                                                            <p>¡Para consultar al pacientes es necesario saber su Cedula de identidad!</p>
                                                        </div>
                                                    </div>
                                                    ",$ide);
                                            }
                                        }
                                    else
                                        {
                                            printf("
                                                    <div class=\"row\">
                                                        <div class=\"col-xs-12 col-md-10 col-md-offset-1\">
                                                            <h4 class=\"text-center\">Consulte un paciente</h4>
                                                        </div>
                                                    </div>
                                                    ");
                                        } 

                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-rojo">
                                <div class="panel-heading">
                                    <h4 class="text-center">Diagnóstico</h4>
                                </div>
                                <div class="panel-body">
                                    <form id="idConsultaNueva_frm" name="consultaNueva_frm" action="php/cpacientes.php" method="POST">
                                        <h4>Informe Medico</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-5 col-md-offset-1">
                                                <div id="divInforme" class="form-group">
                                                    <label for="informe" data-toggle="tooltip" data-placement="right" title="">Informe</label>
                                                    <textarea class="form-control" rows="6" id="informe" name="informe_txt" placeholder=""><?php if (isset($pacienteExiste) && $pacienteExiste == true) {printf("%s",$row['desc_informe_medico']);}  ?></textarea>
                                                </div> 
                                            </div>
                                            <div class="col-xs-12 col-md-5">
                                                <div id="divExamenFisico" class="form-group">
                                                    <label for="examenFisico" data-toggle="tooltip" data-placement="right" title="">Examen Fisico</label>
                                                    <textarea class="form-control" rows="6" id="examenFisico" name="examenFisico_txt" placeholder=""><?php if (isset($pacienteExiste) && $pacienteExiste == true) {printf("%s",$row['desc_examen_fisico']);}  ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-5 col-md-offset-1">
                                                <div id="divdiagnostico" class="form-group">
                                                    <label for="diagnostico" data-toggle="tooltip" data-placement="right" title="">Diagnóstico</label>
                                                    <textarea class="form-control" rows="4" id="diagnostico" name="diagnostico_txt" placeholder=""><?php if (isset($pacienteExiste) && $pacienteExiste == true) {printf("%s",$row['desc_diagnostico']);}  ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <h4>Indicaciones</h4>
                                        <hr>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-4">
                                                <p class="text-center"><b>Fisioterapia</b></p>
                                                <div id="divFisio">
                                                    
                                                    <!-- Aqui se agragan las estructuras de datos para las fisioterapias -->
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="fechaInicio">Inicio</label>
                                                            <div class="input-group" id="inicioSesion">
                                                                <input id="fechaInicio" type="text" class="form-control">
                                                                <div class="input-group-addon"><span class="glyphicon glyphicon-th" aria-hidden="true"></span></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="numeroSesiones">Sesiones</label>
                                                            <input id="numeroSesiones" type="number" min="5" max="30" step="5" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6">
                                                        <button id="idAgregarFisio" type="button" class="btn btn-default btn-block">Añadir Fisio</button>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                        <button id="idRemoverFisio" type="button" class="btn btn-default btn-block">Borrar</button>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <p class="text-center"><b>Refencias para examenes</b></p>
                                                <div id="divExamenes">
                                                    
                                                    <!-- Aqui se agragan las estructuras de datos para los Examenes Medicos -->
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-12">
                                                        <div class="form-group">
                                                            <label for="examen">Nombre del Examen</label>
                                                            <input id="examen" type="text" class="form-control" maxlength="50">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6">
                                                        <button id="idAgregarExamen" type="button" class="btn btn-default btn-block">Añadir Examen</button>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                            <button id="idRemoverExamen" type="button" class="btn btn-default btn-block">Borrar</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-xs-12 col-md-4">
                                                <p class="text-center"><b>Tratamiento Farmacologico</b></p>
                                                <div id="divFarmacos">

                                                    <!-- Aqui se agragan las estructuras de datos para los Farmacos -->
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-xs-12 col-md-6">
                                                        <div class="form-group">
                                                            <label for="selectFarmaco">Selecciona</label>
                                                            <select id="selectFarmaco" class="form-control">
                                                                <option value="0" disabled selected>Complejo Activo</option>
                                                                <?php 
                                                                    while ($row1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC)) 
                                                                        {

                                                                            printf("<option value=\"%s\">%s</option>",$row1["complejo_activo_farmaco"],$row1["complejo_activo_farmaco"]);
                                                                        } 
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="horas">Horas</label>
                                                            <input id="horas" type="number" min="4" max="24" step="2" class="form-control">
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 col-md-3">
                                                        <div class="form-group">
                                                            <label for="dias">Días</label>
                                                            <input id="dias" type="number" min="5" max="365" step="5" class="form-control">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6">
                                                        <button id="idAgregarFarmaco" type="button" class="btn btn-default btn-block">Añadir Farmaco</button>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                        <button id="idRemoverFarmaco" type="button" class="btn btn-default btn-block">Borrar</button>
                                                    </div>

                                                </div>

                                                
                                            </div>
                                        </div>
                                        <input type="hidden" name="tipoConsulta_h"   <?php if (isset($_GET["tabControl_h"]) && isset($_GET["identificacion1_txt"]) || isset($_GET["modificar"])) {printf("value = \"%s\"",$row["id_tipo_consulta"]);} ?>>
                                        <input type="hidden" name="identificacion_h" <?php if (isset($_GET["tabControl_h"]) && isset($_GET["identificacion1_txt"]) || isset($_GET["modificar"])) {printf("value = \"%s\"",$ide);} ?> >
                                        <input type="hidden" name="fechaConsulta_h"  <?php if (isset($_GET["tabControl_h"]) && isset($_GET["identificacion1_txt"]) || isset($_GET["modificar"])) {printf("value = \"%s\"",$row["fecha_consulta"]);} ?> >
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                                            <button id="enviarConsultaNueva_frm" type="button" class="btn btn-default btn-block" form="idConsultaNueva_frm">Finalizar Consulta</button>
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
                <div id="menu3" class="tab-pane fade ">
                    <h3>Resumen Pacientes <small>Apartado con toda la informacion de los pacientes</small> </h3>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Datos</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4 col-md-offset-8">
                                            <form id="idBuscarPaciente1_frm" name="buscarPaciente1_frm" action="pacientes.php" method="GET">
                                                <div id="divIdentificacion2" class="form-group">
                                                    <label for="identificacion2">Buscar Paciente</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control" id="identificacion2" name="identificacion2_txt" placeholder="Identificación" maxlength="10">
                                                        <span class="input-group-btn">
                                                            <button id="enviarBuscarPaciente1_frm" class="btn btn-default" type="button"><span class="glyphicon glyphicon-search"></span></button>
                                                        </span>
                                                    </div>
                                                    <!-- <span class="glyphicon glyphicon-remove form-control-feedback"></span> -->
                                                </div>
                                                <input name="tabControl_h" type="hidden" value="3">
                                            </form>
                                        </div>
                                    </div>
                                    <h4>Tabla de Pacientes</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th style="width:20%" class="text-center">Historial Medico</th>
                                                            <th style="width:10%" class="text-center">Cedula</th>
                                                            <th style="width:30%" colspan="2" class="text-center">Nombre Y Apellido</th>
                                                            <th style="width:30%" colspan="2" class="text-center">Consultas</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                         <?php 
                                                            if (isset($row_cnt5) && $row_cnt5 > 0) {
                                                                while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC)) 
                                                                {
                                                                    //Crear variable de tipo date
                                                                    $fechaHistorial = date_create($row5["fecha_creacion_historial_medico"]);
                                                                    //dar formato a variable creada
                                                                    $fechaHistorialF1 = date_format($fechaHistorial, 'd/m/Y');
                                                                    $fechaHistorialF2 = date_format($fechaHistorial, 'h:i:s A');


                                                                    $consulta = "SELECT 
                                                                                    a.id_consulta,
                                                                                    a.fecha_consulta,
                                                                                    b.nombre_tipo_consulta
                                                                                FROM
                                                                                    consultas a,
                                                                                    tipos_consultas b
                                                                                WHERE
                                                                                    a.id_tipo_consulta = b.id_tipo_consulta
                                                                                AND
                                                                                    id_historial_medico = ".$row5["id_historial_medico"]."
                                                                                ORDER BY
                                                                                    a.id_consulta
                                                                                ";
                                                                    $resultado_con = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de pacientes"); //header('location: ../pacientes.php')
                                                                    $row_cnt_con = mysqli_num_rows($resultado_con);

                                                                    

                                                                    if ($row_cnt_con > 0) {
                                                                        printf("<tr>
                                                                                    <td rowspan =".($row_cnt_con + 1)." class=\"text-center\">%s - %s</td>
                                                                                    <td rowspan =".($row_cnt_con + 1)." class=\"text-center\">%s</td>
                                                                                    <td rowspan =".($row_cnt_con + 1)." class=\"text-center\">%s %s</td>
                                                                                    <td rowspan =".($row_cnt_con + 1)." class=\"text-center\"><a href=\"pacientes.php?modificar=true&id_paciente=%s&tabControl_h=1\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></a></td>
                                                                                ",$row5["id_historial_medico"], $fechaHistorialF1, $row5["ci_paciente"], $row5["nombre_paciente"], $row5["apellido_paciente"],$row5["id_paciente"]);

                                                                        while ($row_con = mysqli_fetch_array($resultado_con, MYSQLI_ASSOC)) {

                                                                            //Crear variable de tipo date
                                                                            $fechaConsulta = date_create($row_con["fecha_consulta"]);
                                                                            //dar formato a variable creada
                                                                            $fechaConsultaF1 = date_format($fechaConsulta, 'd/m/Y');
                                                                            $fechaConsultaF2 = date_format($fechaConsulta, 'h:i:s A');


                                                                            printf("    <tr>
                                                                                            <td class=\"text-center\">%s - %s</td>
                                                                                            <td class=\"text-center\"><a href=\"pacientes.php?modificar=true&tabControl_h=2&id_paciente=%s&id_consulta=%s\" class=\"btn btn-default\"><span class=\"glyphicon glyphicon-pencil\"></span></a></td>
                                                                                        </tr>
                                                                                    ", $fechaConsultaF1, $row_con["nombre_tipo_consulta"], $row5["id_paciente"], $row_con["id_consulta"]);
                                                                        }
                                                                        echo "</tr>";
                                                                        
                                                                    }
                                                                    else
                                                                    {
                                                                        printf("
                                                                            <tr>
                                                                                <td>%s</td>
                                                                                <td>%s</td>
                                                                                <td>%s</td>
                                                                                <td>%s  %s</td>
                                                                                <td>Este paciente no posee consultas</td>
                                                                                <td>Sin Aciones</td>
                                                                            </tr>
                                                                            ",$row5["id_historial_medico"], $row5["fecha_creacion_historial_medico"], $row5["ci_paciente"], $row5["nombre_paciente"], $row5["apellido_paciente"]);

                                                                    }

                                                                    
                                                                }
                                                            }
                                                            else
                                                            {
                                                                printf("
                                                                        <tr>
                                                                            <td colspan=\"6\" class=\"text-center\">No Hay Coincidencias</td>
                                                                        </tr>
                                                                        ");
                                                            }
                                                            
                                                          ?>

                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

	</div>
	<!-- /#wrapper -->


	<footer></footer>

	<?php require("comunes/scripst.php"); ?>
    <script src="js/cpacientes.js"></script>
    <script type="text/javascript">
        $('#inicioSesion input').datepicker({
            language: 'es',
            format: "dd-mm-yyyy",
            startDate: "today",
            maxViewMode: 1,
            autoclose: true,
            todayHighlight: true,
            todayBtn: "linked",
            daysOfWeekDisabled: "0,6"
        });

        $(function(){
            $('a[data-toggle = "tab"]').on('shown.bs.tab', function (e) 
            {
                // Get the name of active tab
                var activeTab = $(e.target).text(); 
         
                // Get the name of previous tab
                var previousTab = $(e.relatedTarget).text(); 
         
                $(".active-tab span").html(activeTab);
                $(".previous-tab span").html(previousTab);
            });
        });
        <?php 
        if (isset($pacienteExiste) && $pacienteExiste == true) 
            {
                if ($row_cnt2 >= 1) 
                {
                    while ($row2 = mysqli_fetch_array($resultado2, MYSQLI_ASSOC)) 
                    {
                        //Crear variable de tipo date
                        $fechaFisio = date_create($row2["fecha_inicio_fisioterapia"]);
                        //dar formato a variable creada
                        $fechaFisioF1 = date_format($fechaFisio, 'd-m-Y');
                        $fechaFisioF2 = date_format($fechaFisio, 'h:i:s A');

                        printf("
                                    addAllInputs('divFisio', '%s', %s, null, null, null, null);
                                ",$fechaFisioF1, $row2['numero_sesiones']);
                    }

                }
                if ($row_cnt3 >= 1) 
                {   
                    while ($row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC)) 
                    {
                        printf("
                                addAllInputs('divExamenes', null, null, '%s' , null, null, null);    
                                ",$row3['nombre_examen']);
                    }
                }
                if ($row_cnt4 >= 1) 
                {
                    while ($row4 = mysqli_fetch_array($resultado4, MYSQLI_ASSOC)) 
                    {
                        printf("
                                    addAllInputs('divFarmacos',null,null, null, '%s', %s, %s);
                                ",$row4["complejo_activo_farmaco"], $row4["intervalo_horas"], $row4["duracion"]);
                    }
                }
            }  
        ?>
    </script>
</body>
</html>