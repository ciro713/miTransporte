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
        <a class="btn-volver" style="text-decoration: none; color: white;" href="../../public/escuela_habilitador.html">VOLVER</a>
    </center>

    <br>

    <h5 style="text-align: center;">Alumnos que fueron habilitados y pertenecen a su establecimiento.</h5>
    <hr>
    <br><br>

<div class="table-container">

<?php
   include('../config/db-connection.php');

if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}


require('../config/sesion.php');

$cue = $_SESSION['id_usuario']; 

$_SESSION['rol'] = "escuela";


$query = "
    SELECT A.nombre_apellido, A.DNI, E.CUE, E.establecimiento_educativo, A.estado_credencial 
    FROM estudiante A
    INNER JOIN establecimiento_educativo E ON A.establecimiento_educativo = E.id_establecimiento_educativo
    WHERE A.estado_credencial = 'habilitado' AND E.CUE = ?
";
$stmt = $conexion->prepare($query);
$stmt->bind_param('s', $cue);
$stmt->execute();
$result = $stmt->get_result();

echo "<table border='1' cellpadding='10' cellspacing='0'>";
echo "<thead>";
echo "<tr>";
echo "<th>Nombre y Apellido</th>";
echo "<th>DNI</th>";
echo "<th>CUE</th>";
echo "<th>Establecimiento Educativo</th>";
echo "<th>Estado Credencial</th>";
echo "</tr>";
echo "</thead>";
echo "<tbody>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $row['nombre_apellido'] . "</td>";
    echo "<td>" . $row['DNI'] . "</td>";
    echo "<td>" . $row['CUE'] . "</td>";
    echo "<td>" . $row['establecimiento_educativo'] . "</td>";
    echo "<td>" . $row['estado_credencial'] . "</td>";
    echo "</tr>";
}

echo "</tbody>";
echo "</table>";

$stmt->close();
?>

</div>
</body>
</html>