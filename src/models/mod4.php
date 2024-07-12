<?php
include('../config/db-connection.php');

if(isset($_POST['id_confirmar'])) {
    $DNI = $_POST['id_confirmar'];

    $query = "UPDATE estudiante SET estado_credencial='habilitado' WHERE DNI = '$DNI'";
    $res = mysqli_query($conexion, $query);

    if ($res) {
        echo '1';
    } else {
        echo '0'; 
    }
} else {
    echo 'No se recibió ningún ID';
}
?>
