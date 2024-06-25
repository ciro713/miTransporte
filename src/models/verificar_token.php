<?php
    include('../config/db-connection.php');


    $cue_token = $conexion->real_escape_string($_POST['CUE_token']);
    $token_verificar = $conexion->real_escape_string($_POST['token']);
    $new_password = $conexion->real_escape_string($_POST['new_password']);

    $sql_token = $conexion->prepare("SELECT `token` FROM `establecimiento_educativo` WHERE `CUE` = (?)");

    
    if ($sql_token) {
        $sql_token->bind_param('s', $cue_token);
        $sql_token->execute();
        $token_resultado = $sql_token->get_result();

        // Comprobar si se obtuvieron resultados
        if ($token_resultado->num_rows > 0) {
            // Fetch el token
            $row = $token_resultado->fetch_assoc();
            $token_establecimiento_educativo = $row['token'];
            $update = array('error' => true, 'mensaje' => 'token:'. $token_establecimiento_educativo.'token recibido:'.$token_verificar);
            //echo "Token: " . $token_establecimiento_educativo;
        } else {
            $update = array('error' => true, 'mensaje' => 'no se encontro ningun registro con ese CUE');
            //echo "No se encontró ningún registro con ese CUE.";
        }

        $sql_token->close();
    } else {
        echo "Error en la preparación de la consulta: " . $conexion->error;
    }

    //$update = array('error' => true, 'mensaje' => 'error al recibir el token');

    if($token_verificar == $token_establecimiento_educativo){

        $new_password = password_hash($new_password, PASSWORD_DEFAULT); // Encriptar la contraseña

        $sql_cambiar_password = $conexion->prepare("UPDATE `usuarios` SET `password` = (?) WHERE `usuario` = (?)");
        $sql_cambiar_password->bind_param('ss', $new_password,$cue_token);
        $sql_cambiar_password->execute();

        $update = array('exito' => true, 'mensaje' => 'la contraseña fue cambiada correctamente');
    }else{
        $update = array('error' => true, 'mensaje' => 'error en la carga de la contraseña');
    }

    header("Content-Type: application/json");
    echo json_encode($update);
    exit();
?>