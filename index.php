<!DOCTYPE html>
<html lang="es">
<head>
	<?php require("comunes/head.php"); ?>
	<link href="css/index.css" rel="stylesheet">
	<title>Inicio</title>
</head>
<body>
	<div class="container-fluid">
		<!-- El contenido de la pagina va aqui -->
		<div class="row">
			<div class="col-xs-10 col-xs-offset-1 col-md-4 col-md-offset-4">
				<form  name="login_frm" action="php/cindex.php" method="post" enctype="application/x-www-from-urlencoded">
					<div>
						<img id="marca" src="img/brand4.png">
					</div>
					<div class=	"form-group">
						<input type="text" class="form-control" id="usuario" placeholder="Nombre de Usuario" name="usuario_txt">
					</div>
					<div class="form-group">
						<input type="password" class="form-control" id="clave" placeholder="Clave Secreta" name="password_pw">
					</div>
					<!--<input class="btn btn-default" type="button" value="Enviar" id="btn_enviar"> -->
				</form>
				<button id="btn_enviar" class="btn btn-default">Entrar</button>
			</div>
		</div>
	</div>
	<footer>
	</footer>

<script src="js/cindex.js"></script>
<?php require("comunes/scripst.php"); ?>
</body>
</html>