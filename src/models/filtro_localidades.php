<?php
include('../config/db-connection.php');

$sql_buscarlocalidades = $conexion->query("SELECT * from localidades");

if ($sql_buscarlocalidades) {
    $localidades = array();
    while ($fila = $sql_buscarlocalidades->fetch_assoc()) {
        $localidades[] = $fila;
    }

    // Devolver las localidades como respuesta JSON
    header("Content-Type: application/json");
    echo json_encode(array('success' => true, 'localidades' => $localidades));
} else {
    // Manejar el error de la consulta SQL
    header("Content-Type: application/json");
    echo json_encode(array('success' => false));
}

$conexion->close();
?>