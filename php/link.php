<?php 
//Pasos para conectarse a la base de datos MYSQL con PHP

//1) conectarse con mysqli_connect

$store = "localhost";
$user = "rehab";
$pass = "1234";
$bd = "rehabdb";

$enlace = mysqli_connect($store, $user, $pass, $bd);

if (!$enlace) {
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "errno de depuración: " . mysqli_connect_errno() . PHP_EOL;
    echo "error de depuración: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>