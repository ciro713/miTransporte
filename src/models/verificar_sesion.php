<?php
    require('../config/sesion.php');
    include('../config/db-connection.php');

    $logeo = array();

    if(isset($_SESSION['id_usuario'])){

        $id_usuario = $_SESSION['id_usuario'];
        $sql_estado = $conexion->prepare("SELECT estado_credencial FROM estudiante WHERE DNI = ?");
        $sql_estado->bind_param("s", $id_usuario);
        $sql_estado->execute();
        $result = $sql_estado->get_result();
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response = $row['estado_credencial'];
            if($response == 'habilitado'){
                $logeo['sesionON'] = true;
            }else{
                $logeo['sesionOFF'] = true;
            }
        }else{
            $logeo['sesionOFF'] = true;
        }
    } else {
        $logeo['sesionOFF'] = true;
    }
    
    header("Content-Type: application/json");
    echo json_encode($logeo);
    exit();
?>