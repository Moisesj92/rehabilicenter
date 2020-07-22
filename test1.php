<?php

 $server = "192.168.1.121";
 $datavase = "pacientes";
 $user = "appweb";
 $password = "1234";

$conexion = odbc_connect("Driver={SQL Server};Server=$server;Database=$database;", $user, $password);
$query_string = "SELECT¨* FROM odb.USERINFO";

$resultado = odbc_exec ( $conexion , $query_string);

echo $resultado;
echo "<br>";
echo "O POl DIos";

?>