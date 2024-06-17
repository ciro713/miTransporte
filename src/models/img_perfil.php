<?php
    require('../config/sesion.php');
    include('../config/db-connection.php');

    if(isset($_SESSION['id_usuario'])){
        $id_usuario = $_SESSION['id_usuario'];
        $sql_img_perfil = $conexion->prepare("SELECT img_estudiante FROM estudiante WHERE DNI = ?");
        $sql_img_perfil->bind_param("s", $id_usuario);
        $sql_img_perfil->execute();
        $result = $sql_img_perfil->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response['status'] = 'success';
            $response['img_estudiante'] = $row['img_estudiante'];
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Sesión no iniciada';
    }

    header("Content-Type: application/json");
    echo json_encode($response);
?>