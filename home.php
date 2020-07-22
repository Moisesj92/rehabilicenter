<?php require("php/session.php") ?>

<!DOCTYPE html>
<html lang="es">
<head>
	<?php require("comunes/head.php"); ?>
	<!-- Custom CSS de Cada Pagina -->
	<title>Pagina Principal</title>
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
                    <h2 class="text-center">Dashboard</h2>
                </div>
            </div>
            <!--Menu selector de tabs -->
            <ul class="nav nav-tabs">
                <li><a data-toggle="tab" href="#principal">Home</a></li>
                <li><a data-toggle="tab" href="#menu1">Menu 1</a></li>
                <li><a data-toggle="tab" href="#menu2">Menu 2</a></li>
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
                <div id="principal" class="tab-pane fade">
                    <h3>HOME</h3>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                </div>
                <div id="menu1" class="tab-pane fade">
                    <h3>Menu 1</h3>
                    <p>Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
                </div>
                <div id="menu2" class="tab-pane fade">
                    <h3>Menu 2</h3>
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

</body>
</html>