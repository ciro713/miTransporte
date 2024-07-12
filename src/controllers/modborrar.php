<?php

include('../config/db-connection.php');

$DNI=$_POST['id_borrar'];

$query="DELETE FROM `estudiante` WHERE `DNI`=$DNI";
$res=mysqli_query($conexion,$query);

if ($res) {
    echo '1';
} else {
    echo '0';
}


?>