<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../../public/img/logo.ico" />
    <title>Alumnos</title>
    <link rel="stylesheet" href="../../public/css/cuerpo.css">
    <link rel="stylesheet" href="../../public/css/habilitacion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f6f9;
        }
        
        .table-container {
            margin: 0 auto;
            max-width: 80%;
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #007bff;
            color: white;
        }
        table tr:hover {
            background-color: #f1f1f1;
        }
        table td {
            color: #333;
        }
        
    </style>
</head>

<body class="body">
    <center>
        <nav class="navbar navbar-expand-md justify-content-center">
            <a class="navbar-brand" href="#">
                <img class="colect" src="../../public/img/image(2).png" alt="Logo">
            </a>
        </nav>
    </center>

    <br><br>

    <center>
        <h1 class="h1">Habilitados</h1>
    </center>

    <center>
        <a class="btn-volver" style="text-decoration: none; color: white;" href="../../public/cooperativa_habilitador.html">VOLVER</a>
    </center>

    <br>

    <h5 style="text-align: center;">Alumnos que fueron habilitados y pertenecen a su establecimiento.</h5>
    <hr>
    <br><br>

<div class="table-container">


<?php

$conexion = new mysqli("localhost", "root", "", "proyecto_credencial");

if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}


require('../config/sesion.php');


$email_cooperativa = $_SESSION['id_usuario']; 


$query = "SELECT id_cooperativa FROM cooperativa WHERE email = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("s", $email_cooperativa);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $id_cooperativa = $row['id_cooperativa'];
} else {
    echo "Cooperativa no encontrada.";
    exit;
}

$query = "
    SELECT E.nombre_apellido, E.DNI, C.cooperativa, EC.estado 
    FROM estudiante E
    INNER JOIN estudiantes_cooperativas EC ON E.id_estudiante = EC.id_estudiante
    INNER JOIN cooperativa C ON EC.id_cooperativa = C.id_cooperativa
    WHERE EC.estado = 'habilitado' AND C.id_cooperativa = ?
";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id_cooperativa);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' cellspacing='0'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th>Nombre y Apellido</th>";
    echo "<th>DNI</th>";
    echo "<th>Cooperativa</th>";
    echo "<th>Estado</th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['nombre_apellido'] . "</td>";
        echo "<td>" . $row['DNI'] . "</td>";
        echo "<td>" . $row['cooperativa'] . "</td>";
        echo "<td>" . $row['estado'] . "</td>";
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
} else {
    echo "No se encontraron estudiantes habilitados para esta cooperativa.";
}
$stmt->close();
?>