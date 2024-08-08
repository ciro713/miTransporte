<?php
include('../config/db-connection.php');
include('../config/sesion.php');

$id_usuario = $_SESSION['id_usuario'];

$cooperativa_query = $conexion->query("SELECT u.usuario, c.id_cooperativa, c.email FROM usuarios u INNER JOIN cooperativa c ON u.usuario = c.email WHERE u.usuario = '$id_usuario'");
$cooperativa_resultado = $cooperativa_query->fetch_assoc();
$id_cooperativa = $cooperativa_resultado['id_cooperativa'];

//$query = "SELECT * FROM estudiante WHERE estado_credencial = 'espera_cooperativa'";
$query = "SELECT e.* FROM estudiante e INNER JOIN estudiantes_cooperativas ec ON e.id_estudiante = ec.id_estudiante WHERE ec.estado = 'espera' AND ec.id_cooperativa = '$id_cooperativa'";
$res = mysqli_query($conexion, $query);

$json = array();
while($row = mysqli_fetch_array($res)) {
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
