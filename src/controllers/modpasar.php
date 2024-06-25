<?php
    include('../config/db-connection.php');
//include('../db-connection.php');

if(isset($_POST['id_confirmar'])) {
    $estado_credencial = $_POST['id_confirmar'];

    $query = "UPDATE estudiante SET estado_credencial='espera_cooperativa' WHERE DNI = $estado_credencial";
    $res = mysqli_query($conexion, $query);

    if ($res) {
        echo 'espera_cooperativa';
    } else {
        echo 'Error al actualizar la base de datos';
    }
} else {
    echo 'No se recibió ningún ID';
}

?>
