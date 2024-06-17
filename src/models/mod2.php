<?php

include('../config/db-connection.php');
include('../config/sesion.php');

$id_usuario = $_SESSION['id_usuario'];

$establecimiento_query = $conexion->query("SELECT `id_establecimiento_educativo` FROM `establecimiento_educativo` WHERE `CUE` = $id_usuario");
$establecimiento_resultado = $establecimiento_query->fetch_assoc();
$id_establecimiento = $establecimiento_resultado['id_establecimiento_educativo'];

$query = "SELECT * FROM `estudiante` WHERE `estado_credencial` != 'estado_cooperativa' AND `establecimiento_educativo` = '$id_establecimiento'";
$res = mysqli_query($conexion, $query);

$json = array();
while ($row = mysqli_fetch_array($res)) {
    $json[] = array(
        'DNI' => $row["DNI"],
        'nombre_apellido' => $row["nombre_apellido"],
        'estado_credencial' => $row["estado_credencial"],
        'documento_frente' => $row["img_documento_frente"],
        'documento_reverso' => $row["img_documento_reverso"],
        'constancia' => $row["img_constancia_alumno"],
        'alumno' => $row["img_estudiante"]
    );
}

$json_string = json_encode($json);
echo $json_string;
?>