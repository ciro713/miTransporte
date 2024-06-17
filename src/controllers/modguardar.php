<?php

include('../config/db-connection.php');
//include('../db-connection.php');
/* echo $_POST ['postDNI']; */

// echo json_encode($_POST);
$DNI = $_POST['postDNI'];
$nombre_apellido = $_POST['postnombre_apellido'];
$estado_credencial = $_POST['postestado_credencial'];

$query="INSERT INTO estudiante (DNI, nombre_apellido, estado_credencial) VALUES ('$DNI','$nombre_apellido','$estado_credencial')";
$res=mysqli_query($conexion,$query);

if ($res) {
    echo 'ok';
} else {
    echo 'error';
}

?>