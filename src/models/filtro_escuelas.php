<?php
include('../config/db-connection.php');

$sql_buscarescuelas = $conexion->query("SELECT * from establecimiento_educativo");

if ($sql_buscarescuelas) {
    $escuelas = array();
    while ($fila = $sql_buscarescuelas->fetch_assoc()) {
        $escuelas[] = $fila;
    }

    // Devolver las escuelas como respuesta JSON
    header("Content-Type: application/json");
    echo json_encode(array('success' => true, 'escuelas' => $escuelas));
} else {
    // Manejar el error de la consulta SQL
    header("Content-Type: application/json");
    echo json_encode(array('success' => false));
}

$conexion->close();
?>
