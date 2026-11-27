<?php
$servidor    = "localhost";
$usuario     = "root";
$clave       = "";
$basededatos = "city_farmac";

$conexion = mysqli_connect($servidor, $usuario, $clave, $basededatos);

if(!$conexion){
    die("Error al conectar con la base de datos: " . mysqli_connect_error());
}

mysqli_query($conexion, "SET NAMES utf8mb4");