<?php 
//insercion de paginas necesarias
    require("php/session.php"); 
//conectar
    require("php/link.php");

//Consultas
    //Tab Modulo Paciente
        //Modificar
        if (isset($_GET["modificar"])) 
        {
            //Recbir Variables
            $mod = $_GET["modificar"];

            //Evitar Insercion Sql
            $mod = mysqli_real_escape_string($enlace, $mod);

            //Tipo de pago
            if ( $mod == "tdp1") 
            {
                //Recibir Variables
                $idTdp = $_GET["idTdp"];

                //Evitar Insercion Sql
                $idTdp = mysqli_real_escape_string($enlace, $idTdp);

                //Consultas
                $consulta = "SELECT * FROM tipos_pagos WHERE id_tipo_pago = ".$idTdp." ";
                $resultado = mysqli_query($enlace, $consulta) or die ("No se pudo consultar los datos del TDP para modificar");
                $row_cnt = mysqli_num_rows($resultado);
                if ($row_cnt > 1) 
                {
                    printf ("<script language=\"JavaScript\">
                                alert(\"Ups! Tenemos un Problema, Hay mas de un tipo de pago con estas caracteristicas\");
                            </script>");
                }
                else
                {
                    $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                }


                //Variables Javascript
                printf ("<script language=\"JavaScript\">
                            tabControl = 1;
                            modificar = \"tdp1\";
                            idTdp = %s
                        </script>",$row["id_tipo_pago"]);



            }
            else if ( $mod == "tdp0")
            {
                //Recibir Variables
                $idTdp = $_GET["idTdp"];

                //Evitar Insercion Sql
                $idTdp = mysqli_real_escape_string($enlace, $idTdp);

                //Consultas
                $consulta = "SELECT * FROM tipos_pagos WHERE id_tipo_pago = ".$idTdp." ";
                $resultado = mysqli_query($enlace, $consulta) or die ("No se pudo consultar los datos del TDP para modificar");
                $row_cnt = mysqli_num_rows($resultado);
                if ($row_cnt > 1) 
                {
                    printf ("<script language=\"JavaScript\">
                                alert(\"Ups! Tenemos un Problema, Hay mas de un tipo de pago con estas caracteristicas\");
                            </script>");
                }
                else
                {
                    $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                }

                //Variables Javascript
                printf ("<script language=\"JavaScript\">
                            tabControl = 1;
                            modificar = \"tdp0\";
                            idTdp = %s
                        </script>",$row["id_tipo_pago"]);


            }
            //Farmaco
            else if ($mod == "far1")
            {
                //recibir Variables
                $idFar = $_GET["idFar"];

                //Evtar Insecion SQl
                $idFar = mysqli_real_escape_string($enlace, $idFar);

                //consulta
                $consulta = "SELECT * FROM farmacos WHERE id_farmaco = ".$idFar." ";
                $resultado = mysqli_query($enlace, $consulta) or die ("No se pudo consultar los datos del farmaco para modificar");
                $row_cnt = mysqli_num_rows($resultado);
                if ($row_cnt >1) 
                {
                    printf ("<script language=\"JavaScript\">
                                alert(\"Ups! Tenemos un Problema, Hay mas de un farmaco con estas caracteristicas\");
                            </script>");
                }
                else
                {
                    $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                }

                //Variables Javascript
                printf ("<script language=\"JavaScript\">
                            tabControl = 1;
                            modificar = \"far1\";
                            idFar = %s
                        </script>",$row["id_farmaco"]);

            }
            else if ($mod == "far0")
            {
                //recibir Variables
                $idFar = $_GET["idFar"];

                //Evtar Insecion SQl
                $idFar = mysqli_real_escape_string($enlace, $idFar);

                //consulta
                $consulta = "SELECT * FROM farmacos WHERE id_farmaco = ".$idFar." ";
                $resultado = mysqli_query($enlace, $consulta) or die ("No se pudo consultar los datos del farmaco para modificar");
                $row_cnt = mysqli_num_rows($resultado);
                if ($row_cnt >1) 
                {
                    printf ("<script language=\"JavaScript\">
                                alert(\"Ups! Tenemos un Problema, Hay mas de un farmaco con estas caracteristicas\");
                            </script>");
                }
                else
                {
                    $row = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                }

                //Variables Javascript
                printf ("<script language=\"JavaScript\">
                            tabControl = 1;
                            modificar = \"far0\";
                            idFar = %s
                        </script>",$row["id_farmaco"]);

            }

            
        }

        //Consulta de tabla pagos
        $consulta = "SELECT * FROM tipos_pagos";
        $resultado1 = mysqli_query($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los tipos de pagos");
        $row_cnt1 = mysqli_num_rows($resultado1);

        //Consulta de tabla Farmacos
        $consulta = "SELECT * FROM farmacos";
        $resultado2 = mysqli_query($enlace, $consulta) or die ("No se pudo ejecutar la consulta de los farmacos");
        $row_cnt2 = mysqli_num_rows($resultado2);

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<?php require("comunes/head.php"); ?>
	<!-- Custom CSS de Cada Pagina -->
	<title>Configuración</title>
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
                    <h2 class="text-center">Configuración</h2>
                </div>
            </div>
            <!--Menu selector de tabs -->
            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#home">Principal</a></li>
                <li><a data-toggle="tab" href="#menu1">Módulo Pacientes</a></li>
                <li><a data-toggle="tab" href="#menu2">Modulo Especialistas</a></li>
                <li><a data-toggle="tab" href="#menu3">Usuarios</a></li>
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
                    <h3>Pagos</h3>
                    <hr>
                    <div class="row">
                    	<div class="col-xs-12 col-md-8 col-md-offset-2">
                    		<div class="panel panel-rojo">
                    			<div class="panel-heading"><h4>Datos del Tipo de Pago</h4></div>
                    			<div class="panel-body">
                    				<form id="idManejarTdp_frm" name="manejarTdp_frm" action="php/cconfiguracion.php" method="POST">
                    					<div class="row">
                    						<div class="col-xs-12 col-md-5 col-md-offset-1">
                    							<div class="form-group">
                    								<label for="nombreTdp">Nombre</label>
                    								<div id="divNombreTdp" class="input-group">
                    									<input id="nombreTdp" type="text" name="nombreTdp_txt" class="form-control" maxlength="15" <?php if (isset($mod)) { if ($mod == "tdp1" || $mod == "tdp0") { printf("value = \"%s\" ",$row["nombre_tipo_pago"]); } } ?> >
                    									<div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Convenio-Seguro-Debito-Efectivo"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span></div>
                    								</div>
                    							</div>
                    						</div>
                    						<div class="col-xs-12 col-md-5">
                    							<div class="form-group">
                    								<label>Descripción</label>
                    								<textarea id="descTdp" name="descTdp_txt" placeholder="Inserte el texto aqui!!" rows="3" class="form-control"><?php if (isset($mod)) { if ($mod == "tdp1" || $mod == "tdp0") {printf("%s",$row["desc_tipo_pago"]); } }?></textarea>
                    							</div>
                    						</div>
                    					</div>
                    				</form>
                    			</div>
                    			<div class="panel-footer">
                    				<div class="row">
                    					<div class="col-xs-12 col-md-4 col-md-offset-2">
                    						<button id="limpiarManejarTdp_frm" type="reset" class="btn btn-default btn-block" form="idManejarTdp_frm">Limpiar</button>
                    					</div>
                    					<div class="col-xs-12 col-md-4">
                                            <?php 
                                                if (isset($mod)) 
                                                {
                                                    if ($mod == "tdp1") 
                                                    {
                                                        printf("<button id=\"enviarManejarTdp_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarTdp_frm\">Modificar</button>");
                                                    }
                                                    else if ($mod == "tdp0")
                                                    {
                                                        printf("<button id=\"enviarManejarTdp_frm\"  type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarTdp_frm\">Eliminar</button>");
                                                    }
                                                    else
                                                    {
                                                       printf("<button id=\"enviarManejarTdp_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarTdp_frm\">Agregar</button>"); 
                                                    }
                                                    
                                                }
                                                else
                                                {
                                                    printf("<button id=\"enviarManejarTdp_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarTdp_frm\">Agregar</button>");
                                                }
                                             ?>
                    						
                    					</div>
                    				</div>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-xs-12 col-md-12">
                    		<div class="panel panel-rojo">
                    			<div class="panel-heading"><h4>Tabla de Tipos de Pagos</h4></div>
                    			<div class="panel-body">
                    				<div class="row">
                    					<div class="col-xs-12 col-md-10 col-md-offset-1">
                    						<div class="table-responsive">
                    							<table class="table">
	                    							<thead>
	                    								<th class="text-center" style="width:20%">Nombre</th>
	                    								<th class="text-center" style="width:60%">Descripcion</th>
	                    								<th class="text-center" style="width:20%">Acciones</th>
	                    							</thead>
	                    							<tbody>
	                    								<?php 
                                                            if ($row_cnt1 >= 1) 
                                                            {
                                                                while ($row1 = mysqli_fetch_array($resultado1, MYSQLI_ASSOC)) 
                                                                {
                                                                    printf ("
                                                                            <tr>
                                                                                <td class=\"text-center\">%s</td>
                                                                                <td class=\"text-left\">%s</td>
                                                                            ",$row1["nombre_tipo_pago"], $row1["desc_tipo_pago"]);

                                                                    if (isset($mod))
                                                                    {
                                                                        if ($mod == "tdp1" || $mod == "tdp0") 
                                                                        {
                                                                            if ($row1["id_tipo_pago"] == $row["id_tipo_pago"]) 
                                                                            {
                                                                                printf("
                                                                                        <td class=\"text-center\"> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp1&idTdp=%s\" disabled><span class=\"glyphicon glyphicon-pencil\"></span></a> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp0&idTdp=%s\" disabled><span class=\"glyphicon glyphicon-remove\"></span></a> </td>
                                                                                        ", $row1["id_tipo_pago"], $row1["id_tipo_pago"]);
                                                                            }
                                                                            else
                                                                            {
                                                                                printf("
                                                                                        <td class=\"text-center\"> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp1&idTdp=%s\"><span class=\"glyphicon glyphicon-pencil\"></span></a> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp0&idTdp=%s\"><span class=\"glyphicon glyphicon-remove\"></span></a> </td>
                                                                                        ", $row1["id_tipo_pago"], $row1["id_tipo_pago"]);
                                                                            }
                                                                        }
                                                                        else
                                                                        {
                                                                            printf("
                                                                                    <td class=\"text-center\"> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp1&idTdp=%s\"><span class=\"glyphicon glyphicon-pencil\"></span></a> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp0&idTdp=%s\"><span class=\"glyphicon glyphicon-remove\"></span></a> </td>
                                                                                ", $row1["id_tipo_pago"], $row1["id_tipo_pago"]);

                                                                        }
                                                                    }
                                                                    else
                                                                    {
                                                                        printf("
                                                                                    <td class=\"text-center\"> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp1&idTdp=%s\"><span class=\"glyphicon glyphicon-pencil\"></span></a> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=tdp0&idTdp=%s\"><span class=\"glyphicon glyphicon-remove\"></span></a> </td>
                                                                                ", $row1["id_tipo_pago"], $row1["id_tipo_pago"]);
                                                                    }
                                                                    
                                                                    printf("</tr>");
                                                                }
                                                            }
                                                            else
                                                            {
                                                                Printf("<tr>
                                                                            <td colspan = \"3\" class=\"text-center\">No Existen Farmacos Registrados</td>
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
                    <h3>Farmacos</h3>
                    <hr>
                    <div class="row">
                    	<div class="col-xs-12 col-md-8 col-md-offset-2">
                    		<div class="panel panel-rojo">
                    			<div class="panel-heading"><h4>Datos del Farmaco</h4></div>
                    			<div class="panel-body">
                    				<form id="idManejarFarmacos_frm" name="manejarFarmacos_frm" action="php/cconfiguracion.php" method="POST">
                    					<div class="row">
                    						<div class="col-xs-12 col-md-5 col-md-offset-1">
                    							<div class="form-group">
                    								<label>Complejo Activo</label>
                    								<div id="divComplejoActivo" class="input-group">
                    									<input id="complejoActivo" type="text" name="complejoActivo_txt" class="form-control" maxlength="20" <?php if (isset($mod)) {  if ($mod == "far1" || $mod == "far0") { printf("value = \"%s\" ",$row["complejo_activo_farmaco"]); }  }?> >
                    									<div class="input-group-addon" data-toggle="tooltip" data-placement="top" title="Ibuprofeno-cetirizina"><span class="glyphicon glyphicon-tint" aria-hidden="true"></span></div>
                    								</div>
                    							</div>
                    						</div>
                    						<div class="col-xs-12 col-md-5">
                    							<div class="form-group">
                    								<label>Nombres Comerciales</label>
                    								<textarea id="nombreComercial" name="nombreComercial_txt" placeholder="Inserte el texto aqui!!" rows="3" class="form-control"><?php if (isset($mod)) {  if ($mod == "far1" || $mod == "far0") { printf( "%s" ,$row["nombre_comercial_farmaco"]); }  }?></textarea>
                    							</div>
                    						</div>
                    					</div>
                    					<div class="row">
                    						<div class="col-xs-12 col-md-6 col-md-offset-3">
                    							<div class="form-group">
                    								<label>Descripción</label>
                    								<textarea id="descFarmaco" name="descFarmaco_txt" placeholder="Inserte el texto aqui!!" rows="3" class="form-control"><?php if (isset($mod)) {  if ($mod == "far1" || $mod == "far0") { printf(" %s ",$row["desc_farmaco"]); }  }?></textarea>
                    							</div>
                    						</div>
                    					</div>
                    				</form>
                    			</div>
                    			<div class="panel-footer">
                    				<div class="row">
                    					<div class="col-xs-12 col-md-4 col-md-offset-2">
                    						<button id="limpiarManejarFarmacos_frm" type="reset" class="btn btn-default btn-block" form="idManejarFarmacos_frm">Limpiar</button>
                    					</div>
                    					<div class="col-xs-12 col-md-4">
                                            <?php 
                                                if (isset($mod)) 
                                                {
                                                    if ($mod == "far1") 
                                                    {
                                                        printf("<button id=\"enviarManejarFarmacos_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarFarmacos_frm\">Modificar</button>");
                                                    }
                                                    else if ($mod == "far0")
                                                    {
                                                        printf("<button id=\"enviarManejarFarmacos_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarFarmacos_frm\">Eliminar</button>");
                                                    }
                                                    else
                                                    {
                                                       printf("<button id=\"enviarManejarFarmacos_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarFarmacos_frm\">Agregar</button>"); 
                                                    }
                                                    
                                                }
                                                else
                                                {
                                                    printf("<button id=\"enviarManejarFarmacos_frm\" type=\"button\" class=\"btn btn-default btn-block\" form=\"idManejarFarmacos_frm\">Agregar</button>");
                                                }
                                             ?>
                    						
                    					</div>
                    				</div>
                    			</div>
                    		</div>
                    	</div>
                    </div>
                    <div class="row">
                    	<div class="col-xs-12 col-md-12">
                    		<div class="panel panel-rojo">
                    			<div class="panel-heading"><h4>Tabla Farmacos</h4></div>
                    			<div class="panel-body">
                    				<div class="row">
                    					<div class="col-xs-12 col-md-10 col-md-offset-1">
                    						<div class="table-responsive">
                    							<table class="table">
	                    							<thead>
	                    								<th class="text-center" style="width:20%">Complejo Activo</th>
	                    								<th class="text-center" style="width:20%">Nombres Comerciales</th>
                                                        <th class="text-center" style="width:40%">Descripción</th>
                                                        <th class="text-center" style="width:20%">Acciones</th>
	                    							</thead>
	                    							<tbody>
	                    								<?php 
                                                            if ($row_cnt2 >= 1) 
                                                            {
                                                                while ($row2 = mysqli_fetch_array($resultado2, MYSQLI_ASSOC)) 
                                                                {

                                                                    printf("
                                                                            <tr>
                                                                                <td class=\"text-center\">%s</td>
                                                                                <td><p> %s </p></td>
                                                                                <td><p> %s </p></td>
                                                                            ", $row2["complejo_activo_farmaco"], $row2["nombre_comercial_farmaco"], $row2["desc_farmaco"]);
                                                                    
                                                                    printf("
                                                                                <td class=\"text-center\"> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=far1&idFar=%s\"><span class=\"glyphicon glyphicon-pencil\"></span></a> <a class=\"btn btn-default btn-sm\" href=\"configuracion.php?modificar=far0&idFar=%s\"><span class=\"glyphicon glyphicon-remove\"></span></a> </td>
                                                                            ", $row2["id_farmaco"], $row2["id_farmaco"]);

                                                                    printf("</tr>");
                                                                }

                                                            }
                                                            else
                                                            {
                                                                Printf("<tr>
                                                                            <td colspan = \"3\" class=\"text-center\">No Existen Farmacos Registrados</td>
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
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                </div>
                <div id="menu3" class="tab-pane fade">
                    <h3>Menu 3</h3>
                    <p>Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- /#page-content-wrapper -->

	</div>
	<!-- /#wrapper -->

	<footer></footer>

	<?php require("comunes/scripst.php"); ?>
    <script src="js/cconfiguracion.js"></script>

</body>
</html>