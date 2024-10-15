<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "proyecto_credencial";

    $conexion = mysqli_connect($servername, $username, $password, $dbname);
    $conexion->set_charset("utf8");

    if ($conexion->connect_error) {
        die("Error de conexión: " . $conexion->connect_error);
    }

?>