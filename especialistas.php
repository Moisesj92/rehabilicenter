<?php 
//insertar Paginas necesarias
require("php/session.php");

//Codigo Funcional de la pag entera
    //conectar
    require("php/link.php");

    //Consultas Generales
    //consult de especialistas
    $consulta = "SELECT
                    id_especialista,
                    nombre_especialista,
                    apellido_especialista
                FROM
                    especialistas
                ";
    $resultado = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los espacialistas"); //header('location: ../pacientes.php')
    //saber si la consulta trae resultados
    $row_cnt = mysqli_num_rows($resultado);

    $resultado1 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los espacialistas"); //header('location: ../pacientes.php')
    //saber si la consulta trae resultados
    $row_cnt1 = mysqli_num_rows($resultado1);

    $resultado6 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los espacialistas");
    $row_cnt6 = mysqli_num_rows($resultado6);

    //Consulta de pacientes
    $consulta= "SELECT
                    id_paciente,
                    nombre_paciente,
                    apellido_paciente
                FROM
                    pacientes
                WHERE
                    id_estatus = 2
                ";
    $resultado2 = mysqli_query($enlace, $consulta) or die ("no se puede ejecutar la consulta de los pacientes");
    $row_cnt2 = mysqli_num_rows($resultado2);



    //Codigo de la tab Horarios
    if (isset($_GET["idEspecialista_sel"]) && isset( $_GET["tabControl_h"]) && isset($_GET["fechaiInicial_txt"]) && isset($_GET["fechaFinal_txt"])) {
        
        $ide = $_GET["idEspecialista_sel"];
        $tabControl = $_GET["tabControl_h"];
        $fecI = $_GET["fechaiInicial_txt"];
        $fecF = $_GET["fechaFinal_txt"];

        //Prevenir insercio sql
        $ide = mysqli_real_escape_string($enlace, $ide);
        $tabControl = mysqli_real_escape_string($enlace, $tabControl);
        $fecI = mysqli_real_escape_string($enlace, $fecI);
        $fecF = mysqli_real_escape_string($enlace, $fecF);

        $fechaInicial = date_create($fecI);
        $fechaFinal = date_create($fecF);

        printf("<script language=\"JavaScript\">
                    var tabControl = %s;
                </script>",$tabControl);
    }

    //codigo de la tab Asignaciones
    if (isset($_GET["paciente_sel"]) && isset($_GET["tabControl_h"])) 
    {
        $idp = $_GET["paciente_sel"];
        $tabControl = $_GET["tabControl_h"];

        //prevenir insercion SQL
        $idp = mysqli_real_escape_string($enlace, $idp);
        $tabControl = mysqli_real_escape_string($enlace, $tabControl);

        printf("<script language=\"JavaScript\">
                    var tabControl = %s;
                </script>",$tabControl);  

    }


    //codigo de la tab Nuevo Especialista
    if (isset($_GET["mostrar_h"]) && isset($_GET["tabControl_h"])) {

        $mostrar = $_GET["mostrar_h"];
        $tabControl = $_GET["tabControl_h"];

        //Prevenir Isercion sql
        $mostrar = mysqli_real_escape_string($enlace, $mostrar);
        $tabControl = mysqli_real_escape_string($enlace, $tabControl);

        //Flujo de informacion para modificar especialista
            if (isset($_GET["id_especialista_href"])) 
            {
                $ide_n = $_GET["id_especialista_href"];
                $ide_n = mysqli_real_escape_string($enlace, $ide_n);
                $consulta = "SELECT * FROM especialistas WHERE id_especialista =   ".$ide_n."  ";
                $resultado4 = mysqli_query($enlace, $consulta) or die ("No se puede ejecutar la consulta para llenar los datos de la modificacion de especialistas");
                $row_cnt4 = mysqli_num_rows($resultado4);
                $row4 = mysqli_fetch_array($resultado4, MYSQLI_ASSOC);
            }

        printf("<script language=\"JavaScript\">
                    var tabControl = %s;
                </script>",$tabControl);    
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
	<?php require("comunes/head.php"); ?>
	<!-- Custom CSS de Cada Pagina -->
	<title>Especialistas</title>
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
                    <h2 class="text-center">Especialistas</h2>
                    <hr>
                        <p class = "active-tab"><strong>Active Tab</strong>: <span></span></p>
                        <p class = "previous-tab"><strong>Previous Tab</strong>: <span></span></p>
                    <hr>
                </div>
            </div>
            <!--Menu selector de tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Principal</a></li>
                <li><a data-toggle="tab" href="#menu1">Especialista</a></li>
                <li><a data-toggle="tab" href="#menu2">Horarios</a></li>
                <li><a data-toggle="tab" href="#menu3">Asignaciones</a></li>
            </ul>
            <!--Contenido Tabs-->
            <div class="tab-content">
                <div id="home" class="tab-pane fade in active">
                    <div class="row">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                            <h3 class="text-center">Bienevido al Modulo Principal</h3>
                            <p class="text-justify">En el modulo principal tendras la posibilidad de visualizar la informacion mas relevante del acontecer diario, te invito a que navegues por todos sus atributos y veas toda la informacion que tiene para ofrecerte</p>
                        </div>
                    </div>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <?php 
                        if (isset($_GET["id_especialista"]))  {
                            printf("
                                        <h3>Modificar Especialista <small>Por Favor modifique los datos necesarioa del especialista</small></h3>
                                ");
                        } 
                        else
                        {
                            printf("
                                        <h3>Nuevo Especialista <small>Por favor Complete los datos del formulario para nuevo especialista</small></h3>
                                ");
                        }
                    ?>
                    <div class="row">
                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Datos del Especialista</h4></div>
                                
                                <div class="panel-body">
                                    <!-- Aqui empieza el formulario para agragar nuevo especialista -->
                                    <form id="idNuevoEspecialista_frm" name="nuevoEspecialista_frm" action="php/cespecialistas.php" method="POST">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-5 col-md-offset-1">
                                            <div id="divIdentificacion" class="form-group">
                                                <label for="identificacion">C.I.</label>
                                                <div class="input-group">
                                                    <input id="identificacion" type="text" name="identificacion_txt" placeholder="" class="form-control" maxlength = "20" <?php if (isset($ide_n)) {printf("value = %s",$row4["ci_especialista"]);}  ?> >
                                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ejemplo: 15555555"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-5">
                                            <div id="divTelf" class="form-group">
                                                <label for="telf">Telefono</label>
                                                <div class="input-group">
                                                    <input id="telf" type="text" name="telf_txt" placeholder="" class="form-control" maxlength="20" <?php if (isset($ide_n)) {printf("value = %s",$row4["telefono_especialista"]);}  ?> >
                                                    <div class="input-group-addon" data-toggle="tooltip" data-placemente="top" title="Ejemplo: 0415-5555555"><span class="glyphicon glyphicon-phone"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-5 col-md-offset-1">
                                            <div id="divNombre" class="form-group">
                                                <label for="">Nombre</label>
                                                <div class="input-group">
                                                    <input id="nombre" type="text" name="nombre_txt" placeholder="" class="form-control" maxlength = "20" <?php if (isset($ide_n)) {printf("value = %s",$row4["nombre_especialista"]);} ?>  >
                                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ejemplo: "><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-md-5">
                                            <div id="divApellido" class="form-group">
                                                <label for="">Apellido</label>
                                                <div class="input-group">
                                                    <input id="apellido" type="text" name="apellido_txt" placeholder="" class="form-control" maxlength = "20" <?php if (isset($ide_n)) {printf("value = %s",$row4["apellido_especialista"]);} ?>   >
                                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ejemplo: "><span class="glyphicon glyphicon-user" aria-hidden="true"></span></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <dic class="col-xs-12 col-md-10 col-md-offset-1">
                                            <div id="divCorreo" class="form-group">
                                                <label for="">Email</label>
                                                <div class="input-group">
                                                    <input id="correo" type="email" name="correo_email" placeholder="" class="form-control" <?php if (isset($ide_n)) {printf("value = %s",$row4["email_especialista"]);} ?> >
                                                    <div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ejemplo: ejemplo@prueba.com"><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></div>
                                                </div>
                                            </div>
                                        </dic>
                                    </div>
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-4 col-md-offset-2">
                                            <button type="reset" class="btn btn-default btn-block" form="idNuevoEspecialista_frm">Limpiar</button>
                                        </div>
                                        <div class="col-xs-6 col-md-4">
                                            <?php if (isset($ide_n)) {
                                                printf("<button id=\"enviaridNuevoEspecialista_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idNuevoEspecialista_frm\">Modificar</button>");
                                            }
                                            else
                                            {
                                                printf("<button id=\"enviaridNuevoEspecialista_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idNuevoEspecialista_frm\">Agregar</button>");
                                            } ?>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>    
                    <div class="row">
                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Tabla de especialistas</h4></div>
                                <div class="panel-body">
                                    <?php 
                                        if (isset ($mostrar)) 
                                        {
                                            if ($mostrar == true && $row_cnt > 0) 
                                            {
                                                 printf("
                                                        <div class=\"table-responsive\">
                                                            <table class=\"table table-hover\">
                                                                <thead>
                                                                    <tr>
                                                                        <th class=\"text-center\">Nombre</th>
                                                                        <th class=\"text-center\">Acción</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                    
                                                    ");

                                                while ($row1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC)) 
                                                {

                                                    if (isset($ide_n) and $ide_n == $row1["id_especialista"]) {
                                                        printf("
                                                                <tr>
                                                                    <td  class = \"text-center\" style= \"width:%s\">%s %s</td>
                                                                    <td class = \"text-center\"><a class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-pencil\"></span></a> <a class=\"btn btn-default disabled\"><span class=\"glyphicon glyphicon-remove\"></span></a></td>
                                                                </tr>

                                                                ", "50%", $row1["nombre_especialista"], $row1["apellido_especialista"]);
                                                        
                                                    }
                                                    else
                                                    {
                                                        printf("
                                                                <tr>
                                                                    <td class = \"text-center\"  style= \"width:%s\">%s %s</td>
                                                                    <td class = \"text-center\"><a class=\"btn btn-default\" href=\"especialistas.php?tabControl_h=1&mostrar_h=true&id_especialista_href=%s\"><span class=\"glyphicon glyphicon-pencil\"></span></a> <a class=\"btn btn-default\" onclick=\"eliminar(%s)\"><span class=\"glyphicon glyphicon-remove\"></span></a></td>
                                                                </tr>

                                                                ", "50%", $row1["nombre_especialista"], $row1["apellido_especialista"], $row1["id_especialista"], $row1["id_especialista"]);
                                                    }
                                                        
                                                }

                                                printf("

                                                                    </tbody>    
                                                                </table>
                                                            </div>
                                                        ");
                                            }
                                            else
                                            {
                                                printf("¡Vaya! Parece que aun no se ha registrado ningun especialista");
                                            }
                                           
                                        }
                                        else
                                        {
                                            printf ("<p class=\"text-justify\">Presiona el boton <b>Mostar</b> para consultar la lista de especialistas que trabajan actualmente.</p>");
                                        }


                                     ?>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                                            <a class="btn btn-default btn-block" href="especialistas.php?tabControl_h=1&mostrar_h=true" role="button">Mostrar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Consulta de horarios <small>Por favor complete los datos del formulario para consultar horarios</small></h3>
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Especialista</h4></div>
                                <div class="panel-body">
                                    <form id="idConsultarHorario_frm" name="consultarHorario_frm" action="especialistas.php" method="GET">
                                        <div class="row">
                                            <div class="col-xs-12 col-md-10 col-md-offset-1">
                                                <div class="form-group">
                                                    <!-- <label for="">Selecione un especialista</label> -->
                                                    <select id="especialista" class="form-control" name="idEspecialista_sel">
                                                        <option value="0" selected>Seleccione un especialista</option>
                                                        <?php 
                                                            while ($row = mysqli_fetch_array($resultado, MYSQLI_ASSOC)) {
                                                                printf("
                                                                        <option value=\"%s\">%s %s</option>
                                                                        ",$row["id_especialista"], $row["nombre_especialista"], $row["apellido_especialista"]);
                                                            }
                                                         ?>
                                                    </select>
                                                    <input id="tabControl" type="hidden" name="tabControl_h" value="2">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-12 col-md-10 col-md-offset-1">
                                                <div class="input-daterange input-group" id="datepicker">
                                                    <input id="idFechaInicial" type="text" class="form-control" name="fechaiInicial_txt" />
                                                    <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
                                                    <input id="idFechaFinal" type="text" class="form-control" name="fechaFinal_txt" />
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                                            <button id="enviarConsultarHorario_frm" type="button" class="btn btn-default btn-block" form="idConsultarHorario_frm">Consultar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Horario del especialista</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-6 col-md-5 col-md-offset-1">
                                            <p>
                                                <b>Fecha Inicial:</b> <?php if(isset($fechaInicial)) {printf("%s", date_format($fechaInicial, 'd-m-Y'));}else{printf("30/02/201");} ; ?>
                                            </p>
                                        </div>
                                        <div class="col-xs-6 col-md-5">
                                            <p class="text-right">
                                                <b>Fecha Final:</b> <?php if(isset($fechaFinal)) {printf("%s", date_format($fechaFinal, 'd-m-Y'));}else{printf("30/02/201");} ?>
                                            </p>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-bordered">
                                            <thead>
                                                <tr>
                                                    
                                                <?php
                                                    if (isset($ide) && isset($fecI) && isset($fecF)) 
                                                    {
                                                        printf("<th class=\"text-center\">Hora</th>");
                                                        //Sacar la diferencia entre 2 fechas
                                                        $intervalo = date_diff($fechaInicial, $fechaFinal);
                                                        //mostrar cuantos dias hay de diferencia entre 2 fechas
                                                        $controlInt =$intervalo->format('%a');

                                                        //Creamos Feccha de control
                                                        $fechaControl = date_create($fecI);


                                                        for($i=0 ; $i<=$controlInt ; $i++)
                                                        {
                                                            if ( $i== 0) 
                                                            {
                                                                //Imprimir Pimer dia del bucle
                                                                printf("<th class=\"text-center\" colspan=\"3\">%s</th>",date_format($fechaControl,'d-M'));
                                                            }
                                                            else
                                                            {
                                                                date_add($fechaControl, date_interval_create_from_date_string('1 days'));
                                                                $controlFines = date_format($fechaControl, 'D');

                                                                if ($controlFines == "Sat" || $controlFines == "Sun") 
                                                                {
                                                                    //No Hacer nada
                                                                }
                                                                else
                                                                {
                                                                    printf("<th class=\"text-center\" colspan=\"3\">%s</th>", date_format($fechaControl,'d-M'));
                                                                }
                                                                
                                                            }
                                                        }
                                                    }
                                                ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                    if (isset($ide) && isset($tabControl) && isset($fecI) && isset($fecF)) 
                                                    {
                                                        //hora Inicial del Calendario
                                                        $hora = 7;
                                                        $meridian = "Am";

                                                        //ciclo para cada fila
                                                        for($i=0; $i<10 ; $i++)
                                                        {
                                                            if ($hora == 12) 
                                                            {
                                                                $hora = 13;
                                                                $meridian = "Pm";
                                                            }
                                                            //Crear Hora en formato 12 horas
                                                            if ($meridian == "Am") 
                                                            {
                                                                printf("<tr class=\"text-center\">
                                                                        <td>%s %s</td>
                                                                    ",$hora, $meridian);
                                                            }
                                                            else
                                                            {
                                                                printf("<tr class=\"text-center\">
                                                                        <td>%s %s</td>
                                                                    ",$hora-12, $meridian);
                                                            }
                                                            

                                                            $fechaControl = date_create($fecI);
                                                            
                                                            //aumentar la fecha en 7 horas
                                                            date_add($fechaControl, date_interval_create_from_date_string(''.$hora.'hours'));

                                                                //Llenar espacios con fisioterapias
                                                                for($j=0; $j<=($controlInt); $j++)
                                                                {  
                                                                    //Si es el primer Ciclo
                                                                    if ($j == 0) 
                                                                    {   
                                                                        //Imprimir fisioterapias

                                                                        //Buscar las fisioterapias asignadas a esta fecha y hora y a este especialista
                                                                        $consulta = "SELECT
                                                                                        a.id_fisioterapia,
                                                                                        a.horario_fisioterapia, 
                                                                                        a.sesion_fisioterapia,
                                                                                        a.id_estatus_fisioterapia,
                                                                                        f.ci_paciente,
                                                                                        f.nombre_paciente,
                                                                                        f.apellido_paciente
                                                                                    FROM
                                                                                        fisioterapias a,
                                                                                        indicaciones_fisioterapias b,
                                                                                        indicaciones c,
                                                                                        consultas d,
                                                                                        historiales_medicos e,
                                                                                        pacientes f
                                                                                    WHERE
                                                                                        a.id_especialista = ".$ide."
                                                                                    AND
                                                                                        a.horario_fisioterapia = '".date_format($fechaControl,'Y-m-d H:i:s')."'
                                                                                    AND
                                                                                        a.id_indicacion_fisioterapia = b.id_indicacion_fisioterapia
                                                                                    AND
                                                                                        b.id_indicacion = c.id_indicacion
                                                                                    AND
                                                                                        c.id_consulta = d.id_consulta
                                                                                    AND
                                                                                        d.id_historial_medico = e.id_historial_medico
                                                                                    AND
                                                                                        e.id_paciente = f.id_paciente
                                                                                    ORDER BY
                                                                                        a.id_fisioterapia
                                                                                    ";
                                                                        $resultado3 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de las fisiterapias"); //header('location: ../pacientes.php')
                                                                        //saber si la consulta trae resultados
                                                                        $row_cnt3 = mysqli_num_rows($resultado3);

                                                                        switch ($row_cnt3) 
                                                                            {
                                                                                case '0':
                                                                                    for($k=0; $k<3; $k++)
                                                                                    {
                                                                                        printf("<td>-</td>");                                                                            
                                                                                    }
                                                                                    break;
                                                                                case '1':
                                                                                    $row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC);
                                                                                    if ($row3["id_estatus_fisioterapia"] == 2) 
                                                                                    {
                                                                                        printf("
                                                                                                <td class=\"text-center\" colspan=\"1\">
                                                                                                    <p>%s %s</p>
                                                                                                    <p>Sesión: %s</p>
                                                                                                    <button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Asignada\">
                                                                                                        <span class=\"glyphicon glyphicon-info-sign\"></span>
                                                                                                    </button>
                                                                                                </td>
                                                                                                ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                    }
                                                                                    else if ($row3["id_estatus_fisioterapia"] == 3) 
                                                                                    {
                                                                                        printf("
                                                                                                <td class=\"text-center\" colspan=\"1\">
                                                                                                    <p>%s %s</p>
                                                                                                    <p>Sesión: %s</p>
                                                                                                    <button type=\"button\" class=\"btn btn-success btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Completada\">
                                                                                                        <span class=\"glyphicon glyphicon-ok-sign\"></span>
                                                                                                    </button>
                                                                                                </td>
                                                                                                ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                    }
                                                                                    else if ($row3["id_estatus_fisioterapia"] == 4)
                                                                                    {
                                                                                        printf("
                                                                                                <td class=\"text-center\" colspan=\"1\">
                                                                                                    <p>%s %s</p>
                                                                                                    <p>Sesión: %s</p>
                                                                                                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Falta\">
                                                                                                        <span class=\"glyphicon glyphicon-remove-sign\"></span>
                                                                                                    </button>
                                                                                                </td>
                                                                                                ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 

                                                                                    }
                                                                                    
                                                                                    for($k=0; $k<2; $k++)
                                                                                    {
                                                                                        printf("<td>-</td>");
                                                                                    }
                                                                                    break;
                                                                                case '2':
                                                                                    while ($row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC)) 
                                                                                    {
                                                                                        if ($row3["id_estatus_fisioterapia"] == 2) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Asignada\">
                                                                                                            <span class=\"glyphicon glyphicon-info-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 3) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-success btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Completada\">
                                                                                                            <span class=\"glyphicon glyphicon-ok-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 4)
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Falta\">
                                                                                                            <span class=\"glyphicon glyphicon-remove-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 

                                                                                        }
                                                                                    }
                                                                                    
                                                                                    for($k=0; $k<1; $k++)
                                                                                    {
                                                                                        printf("<td>-</td>"); 
                                                                                    }
                                                                                    break;
                                                                                case '3':
                                                                                    while ($row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC)) 
                                                                                    {
                                                                                        if ($row3["id_estatus_fisioterapia"] == 2) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Asignada\">
                                                                                                            <span class=\"glyphicon glyphicon-info-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 3) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-success btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Completada\">
                                                                                                            <span class=\"glyphicon glyphicon-ok-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 4)
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Falta\">
                                                                                                            <span class=\"glyphicon glyphicon-remove-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 

                                                                                        }
                                                                                    }
                                                                                    break;
                                                                                default:

                                                                                    for($k=0; $k<3; $k++)
                                                                                    {
                                                                                        printf("<td>Error</td>");                                                                            
                                                                                    }
                                                                                    break;
                                                                            }
                                                                    }
                                                                    //Los demas Ciclos
                                                                    else
                                                                    {

                                                                        //aumentar la fecha en 1 dia
                                                                        date_add($fechaControl, date_interval_create_from_date_string('1 days'));

                                                                        $controlFines = date_format($fechaControl, 'D');

                                                                        if ($controlFines == "Sat" || $controlFines == "Sun") 
                                                                        {
                                                                            //No Hacer nada
                                                                        }
                                                                        else
                                                                        {
                                                                            //Imprimir Fisioterapias

                                                                            //Buscar las fisioterapias asignadas a esta fecha y hora y a este especialista
                                                                            $consulta = "SELECT
                                                                                            a.id_fisioterapia,
                                                                                            a.horario_fisioterapia, 
                                                                                            a.sesion_fisioterapia,
                                                                                            a.id_estatus_fisioterapia,
                                                                                            f.ci_paciente,
                                                                                            f.nombre_paciente,
                                                                                            f.apellido_paciente
                                                                                        FROM
                                                                                            fisioterapias a,
                                                                                            indicaciones_fisioterapias b,
                                                                                            indicaciones c,
                                                                                            consultas d,
                                                                                            historiales_medicos e,
                                                                                            pacientes f
                                                                                        WHERE
                                                                                            a.id_especialista = ".$ide."
                                                                                        AND
                                                                                            a.horario_fisioterapia = '".date_format($fechaControl,'Y-m-d H:i:s')."'
                                                                                        AND
                                                                                            a.id_indicacion_fisioterapia = b.id_indicacion_fisioterapia
                                                                                        AND
                                                                                            b.id_indicacion = c.id_indicacion
                                                                                        AND
                                                                                            c.id_consulta = d.id_consulta
                                                                                        AND
                                                                                            d.id_historial_medico = e.id_historial_medico
                                                                                        AND
                                                                                            e.id_paciente = f.id_paciente
                                                                                        ORDER BY
                                                                                            a.id_fisioterapia
                                                                                        ";
                                                                            $resultado3 = mysqli_query ($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los espacialistas"); //header('location: ../pacientes.php')
                                                                            //saber si la consulta trae resultados
                                                                            $row_cnt3 = mysqli_num_rows($resultado3);

                                                                            switch ($row_cnt3) 
                                                                            {
                                                                                case '0':
                                                                                    for($k=0; $k<3; $k++)
                                                                                    {
                                                                                        printf("<td>-</td>");                                                                            
                                                                                    }
                                                                                    break;
                                                                                case '1':
                                                                                    $row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC);
                                                                                    if ($row3["id_estatus_fisioterapia"] == 2) 
                                                                                    {
                                                                                        printf("
                                                                                                <td class=\"text-center\" colspan=\"1\">
                                                                                                    <p>%s %s</p>
                                                                                                    <p>Sesión: %s</p>
                                                                                                    <button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Asignada\">
                                                                                                        <span class=\"glyphicon glyphicon-info-sign\"></span>
                                                                                                    </button>
                                                                                                </td>
                                                                                                ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                    }
                                                                                    else if ($row3["id_estatus_fisioterapia"] == 3) 
                                                                                    {
                                                                                        printf("
                                                                                                <td class=\"text-center\" colspan=\"1\">
                                                                                                    <p><small>%s %s</small></p>
                                                                                                    <p><small>Sesión: %s</small></p>
                                                                                                    <button type=\"button\" class=\"btn btn-success btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Completada\">
                                                                                                        <span class=\"glyphicon glyphicon-ok-sign\"></span>
                                                                                                    </button>
                                                                                                </td>
                                                                                                ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                    }
                                                                                    else if ($row3["id_estatus_fisioterapia"] == 4)
                                                                                    {
                                                                                        printf("
                                                                                                <td class=\"text-center\" colspan=\"1\">
                                                                                                    <p>%s %s</p>
                                                                                                    <p>Sesión: %s</p>
                                                                                                    <button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Falta\">
                                                                                                        <span class=\"glyphicon glyphicon-remove-sign\"></span>
                                                                                                    </button>
                                                                                                </td>
                                                                                                ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 

                                                                                    }
                                                                                    for($k=0; $k<2; $k++)
                                                                                    {
                                                                                        printf("<td>-</td>");
                                                                                    }
                                                                                    break;
                                                                                case '2':
                                                                                    while ($row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC)) 
                                                                                    {
                                                                                        if ($row3["id_estatus_fisioterapia"] == 2) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Asignada\">
                                                                                                            <span class=\"glyphicon glyphicon-info-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 3) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-success btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Completada\">
                                                                                                            <span class=\"glyphicon glyphicon-ok-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 4)
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Falta\">
                                                                                                            <span class=\"glyphicon glyphicon-remove-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 

                                                                                        }                                                                                    }
                                                                                    
                                                                                    for($k=0; $k<1; $k++)
                                                                                    {
                                                                                        printf("<td>-</td>"); 
                                                                                    }
                                                                                    break;
                                                                                case '3':
                                                                                    while ($row3 = mysqli_fetch_array($resultado3, MYSQLI_ASSOC)) 
                                                                                    {
                                                                                        if ($row3["id_estatus_fisioterapia"] == 2) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-info btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Asignada\">
                                                                                                            <span class=\"glyphicon glyphicon-info-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 3) 
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-success btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Completada\">
                                                                                                            <span class=\"glyphicon glyphicon-ok-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 
                                                                                        }
                                                                                        else if ($row3["id_estatus_fisioterapia"] == 4)
                                                                                        {
                                                                                            printf("
                                                                                                    <td class=\"text-center\" colspan=\"1\">
                                                                                                        <p>%s %s</p>
                                                                                                        <p>Sesión: %s</p>
                                                                                                        <button type=\"button\" class=\"btn btn-danger btn-sm\" data-toggle=\"popover\" data-placement=\"bottom\" data-content=\"Falta\">
                                                                                                            <span class=\"glyphicon glyphicon-remove-sign\"></span>
                                                                                                        </button>
                                                                                                    </td>
                                                                                                    ",$row3["nombre_paciente"], $row3["apellido_paciente"], $row3["sesion_fisioterapia"]); 

                                                                                        }
                                                                                    }
                                                                                    break;
                                                                                default:

                                                                                    for($k=0; $k<3; $k++)
                                                                                    {
                                                                                        printf("<td>Error</td>");                                                                            
                                                                                    }
                                                                                    break;
                                                                            }
                                                                        }
                                                                    }
                                                                }

                                                            printf("</tr>");
                                                            $hora++;
                                                        }
                                                    }
                                                    else
                                                    {
                                                        printf("<tr>Porfavor Selecione a un Especialista</tr>");
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
                <div id="menu3" class="tab-pane fade">
                    <h3>Asignar Especialista <small></small></h3>
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-offset-3">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Consultar paciente</h4></div>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <!-- Formulario para consultar fisioterapias del paciente-->
                                            <form id="idConsultarPaciente_frm" name="consultarPaciente_frm" action="especialistas.php" method="GET">
                                                <div class="form-group">
                                                    <select id="paciente" name="paciente_sel" class="form-control">
                                                        <option value="0" selected>Seleccione un paciente</option>
                                                        <?php 
                                                            while ($row2 = mysqli_fetch_array($resultado2, MYSQLI_ASSOC)) 
                                                            {
                                                                printf("<option value=\"%s\">%s %s</option>", $row2["id_paciente"], $row2["nombre_paciente"], $row2["apellido_paciente"]);
                                                            }
                                                         ?>
                                                    </select>
                                                </div>
                                                <input id="tabControl" type="hidden" name="tabControl_h" value="3">
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-8 col-md-offset-2">
                                            <button id="enviarConsultarPaciente_frm" type="button" class="btn btn-default btn-block" form="idConsultarPaciente_frm">Consultar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12">
                            <div class="panel panel-rojo">
                                <div class="panel-heading"><h4>Datos</h4></div>
                                <div class="panel-body">
                                    <h4>Tabla De Fisioterapias</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <?php 
                                                if (isset($_GET["paciente_sel"]) && isset($_GET["tabControl_h"])) 
                                                {
                                                    $consulta = "SELECT
                                                                    b.id_consulta,
                                                                    b.fecha_consulta,
                                                                    c.id_indicacion
                                                                FROM
                                                                    historiales_medicos a,
                                                                    consultas b,
                                                                    indicaciones c
                                                                WHERE
                                                                    a.id_paciente = ".$idp."
                                                                AND
                                                                    a.id_historial_medico = b.id_historial_medico
                                                                AND
                                                                    b.id_consulta = c.id_consulta
                                                                ";
                                                    $resultado4 = mysqli_query($enlace, $consulta) or die ("No se puede ejecutar la consulta para llenar la tabla de fisioterapoas sin asignar");
                                                    $row_cnt4 = mysqli_num_rows($resultado4);

                                                    //Row para el select
                                                    $resultado7 = mysqli_query($enlace, $consulta) or die ("No se puede ejecutar la consulta para llenar el select de consultas de fisioterapias sin asignar");
                                                    $row_cnt7 = mysqli_num_rows($resultado7);

                                                    //cosntruir tabla para las asignaciones
                                                    printf("<table class=\"table\">
                                                                    <thead>
                                                                        <tr>
                                                                            <th class=\"text-center\" style = \"width:%s\">Consulta</th>
                                                                            <th class=\"text-center\" style = \"width:%s\">Fisioterapia</th>
                                                                            <th class=\"text-center\" style = \"width:%s\">Fecha</th>
                                                                            <th class=\"text-center\" style = \"width:%s\">Estatus</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>", '40%', '10%', '25%', '25%');
                                                    if ($row_cnt4 >= 1)
                                                    {
                                                        $ahora = date("Y-m-d H:i:s");
                                                        while ($row4 = mysqli_fetch_array($resultado4, MYSQLI_ASSOC))
                                                        {
                                                            //Consultar fisioterapias de la consulta
                                                            $consulta = "SELECT
                                                                            c.id_especialista,
                                                                            c.sesion_fisioterapia,
                                                                            c.horario_fisioterapia,
                                                                            c.id_estatus_fisioterapia,
                                                                            d.nombre_estatus_fisioterapia
                                                                        FROM
                                                                            indicaciones a,
                                                                            indicaciones_fisioterapias b,
                                                                            fisioterapias c,
                                                                            estatus_fisioterapias d
                                                                        WHERE
                                                                            c.id_estatus_fisioterapia BETWEEN 1 AND 2
                                                                        AND
                                                                            c.horario_fisioterapia >= '".$ahora."'
                                                                        AND
                                                                            a.id_indicacion = ".$row4["id_indicacion"]."
                                                                        AND
                                                                            a.id_indicacion = b.id_indicacion
                                                                        AND
                                                                            b.id_indicacion_fisioterapia = c.id_indicacion_fisioterapia
                                                                        AND
                                                                            c.id_estatus_fisioterapia = d.id_estatus_fisioterapia
                                                                        ORDER BY
                                                                                c.sesion_fisioterapia
                                                                        ";
                                                            $resultado5 = mysqli_query($enlace, $consulta) or die ("No se puede ejecutar la consulta para llenar las lineas de consultas en la tabla");
                                                            $row_cnt5 = mysqli_num_rows($resultado5);

                                                            if ($row_cnt5 == 0) 
                                                            {
                                                                $fechaConsulta = date_create($row4["fecha_consulta"]);
                                                                $fechaConsultaF1 = date_format($fechaConsulta,'d-m-y / h:i a');
                                                                //Construir filas por consulta
                                                                printf("
                                                                        <tr>
                                                                            <td>%s</td>
                                                                            <td colspan=\"3\">Todas las fisioterapias de esta consulta ya fueron aplicadas o su fecha de aplicación ya pasó<td>
                                                                        </tr>  
                                                                        ", $fechaConsultaF1);
                                                            }
                                                            else
                                                            {
                                                                //Formatear fechas
                                                                    $fechaConsulta = date_create($row4["fecha_consulta"]);
                                                                    $fechaConsultaF1 = date_format($fechaConsulta,'d-m-y / h:i a');
                                                                    
                                                                printf("
                                                                        <tr class=\"text-center\">
                                                                        <td rowspan = \"%s\" >%s</td>
                                                                        ",$row_cnt5 + 1. , $fechaConsultaF1);


                                                                while ($row5 = mysqli_fetch_array($resultado5, MYSQLI_ASSOC) ) 
                                                                {
                                                                    //Formatear Fechas
                                                                    $fechaFisioterapia = date_create($row5["horario_fisioterapia"]);
                                                                    $fechaFisioterapiaF1 = date_format($fechaFisioterapia, 'd-m - h:i a');

                                                                    //Construir lo que queda de la fila
                                                                    if (date_format($fechaFisioterapia,'H') == 00) 
                                                                    {
                                                                        $fechaFisioterapiaF1 = date_format($fechaFisioterapia, 'd-m');
                                                                        printf("
                                                                                <tr>
                                                                                    <td class=\"text-center\">%s</td>
                                                                                    <td class=\"text-center\">%s</td>
                                                                                    <td class=\"text-center\">%s</td>
                                                                                </tr>
                                                                                ",$row5["sesion_fisioterapia"], $fechaFisioterapiaF1 , $row5["nombre_estatus_fisioterapia"]);
                                                                    }
                                                                    else
                                                                    {
                                                                        printf("
                                                                                <tr>
                                                                                    <td class=\"text-center\">%s</td>
                                                                                    <td class=\"text-center\">%s</td>
                                                                                    <td class=\"text-center\">%s</td>
                                                                                </tr>
                                                                                ",$row5["sesion_fisioterapia"], $fechaFisioterapiaF1 , $row5["nombre_estatus_fisioterapia"]); 
                                                                    }
                                                                }

                                                                printf("
                                                                        </tr> 
                                                                        "); 
                                                            }
                                                        }
                                                    }
                                                    else
                                                    {
                                                        printf("
                                                                <tr>
                                                                    <td class=\"text-center\" colspan=\"5\">Este Paciente no tiene consultas registradas</td>
                                                                </tr>
                                                                ");
                                                    }
                                                    printf("    </tbody>
                                                            </table>
                                                            ");   
                                                }
                                                else
                                                {
                                                  printf("
                                                        <table class=\"table\">
                                                            <tehad>
                                                                <tr>
                                                                    <th>Consulta</th>
                                                                    <th>Fisioterapia</th>
                                                                    <th>Fecha</th>
                                                                    <th>Estatus</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td class=\"text-center\" colspan=\"4\">Consulte un Pacinte</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        ");  
                                                }
                                             ?>
                                        </div>
                                    </div>
                                    <h4>Asignación De Fisioterapias</h4>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 col-md-10 col-md-offset-1">
                                            <form id="idAsignacion_frm" name="asignacion_frm" action="php/cespecialistas.php" method="POST">
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="idConsulta">Consulta</label>
                                                            <select id="idConsulta" name="idConsulta_sel" class="form-control">
                                                                <option value="0" selected disabled>Seleccione una Consulta</option>
                                                                <?php
                                                                    if (isset($_GET["paciente_sel"]) && isset($_GET["tabControl_h"])) 
                                                                    {
                                                                        if ($row_cnt5 != 0)
                                                                        {
                                                                            while ($row7 = mysqli_fetch_array($resultado7, MYSQLI_ASSOC))
                                                                            {
                                                                                $fechaConsulta = date_create($row7["fecha_consulta"]);
                                                                                $fechaConsultaF1 = date_format($fechaConsulta,'d-m-y');
                                                                                printf("<option value=\"%s\">%s</option>", $row7["id_consulta"], $fechaConsultaF1);
                                                                            }    
                                                                        }
                                                                        
                                                                    }                                                                        
                                                                ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                        <div class="form-group">
                                                        <label for="sesionInicial">Sesiónes Fisioterapias</label>
                                                            <div class="input-group">
                                                                <input id="sesionInicial" type="number" name="sesionInicial_num" placeholder="Primera Sesion" class="form-control">
                                                                <div class="input-group-addon"> <span class="glyphicon glyphicon-transfer"></span> </div>
                                                                <input id="sesionFinal" type="number" name="sesionFinal_num" placeholder="Ultima Sesion" class="form-control">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-xs-6 col-md-6">
                                                        <label for="horario">Horario</label>
                                                        <select id="horario" name="horario_sel" class="form-control">
                                                            <option value="0" selected disabled>Seleccione un Horario</option>
                                                            <option value="7">7 Am</option>
                                                            <option value="8">8 Am</option>
                                                            <option value="9">9 Am</option>
                                                            <option value="10">10 Am</option>
                                                            <option value="11">11 Am</option>
                                                            <option value="13">1 Pm</option>
                                                            <option value="14">2 Pm</option>
                                                            <option value="15">3 Pm</option>
                                                            <option value="16">4 Pm</option>
                                                            <option value="17"1>5 Pm</option>
                                                        </select>
                                                        <input type="hidden" name="idPaciente_h" <?php if (isset($_GET["paciente_sel"]) && isset($_GET["tabControl_h"])) { printf("value = \"%s\" ", $idp);}else{printf("value=\"0\"");} ?> >
                                                    </div>
                                                    <div class="col-xs-6 col-md-6">
                                                        <div class="form-group">
                                                            <label for="especialista1">Especialista</label>
                                                            <select id="especialista1" class="form-control" name = "idEspecialista1_sel">
                                                                <option value="0" selected disabled>Seleccione un especialista</option>
                                                                <?php 
                                                                    while ($row6 = mysqli_fetch_array($resultado6, MYSQLI_ASSOC)) 
                                                                    {
                                                                        printf("
                                                                                <option value=\"%s\">%s %s</option>
                                                                                ",$row6["id_especialista"], $row6["nombre_especialista"], $row6["apellido_especialista"]);
                                                                    }                                                                  
                                                                 ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <div class="row">
                                        <div class="col-xs-12 col-md-4 col-md-offset-4">
                                            <button id="eviarIdAsignacion_frm" type="button" class="btn btn-default btn-block" form="idAsignacion_frm">Asignar Fisioterapias</button>
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
    <script src="js/cespecialistas.js"></script>
    <script type="text/javascript">
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


        $(function () {
            $('[data-toggle="popover"]').popover()
        })

        $('.input-daterange').datepicker({
            format: "dd-mm-yyyy",
            weekStart: 1,
            maxViewMode: 2,
            language: "es",
            daysOfWeekDisabled: "0,6",
            calendarWeeks: true,
            todayBtn: "linked",
            todayHighlight: true
        });
        

    </script>

</body>
</html>