<?php
    require('../config/sesion.php');
    include('../config/db-connection.php');

    $usuario = $_SESSION['id_usuario'];
    $rol = $_SESSION['rol'];

    //estudiantes habilitados
    $sql_datos_habilitados = $conexion->prepare("SELECT * FROM estudiante WHERE estado_credencial = ?");
    $estado_hab = "habilitado";
    $sql_datos_habilitados->bind_param("s", $estado_hab);
    $sql_datos_habilitados->execute();
    $result_hab = $sql_datos_habilitados->get_result();
    $alumnos_hab = $result_hab->num_rows;

    if($rol == "escuela"){       
        //nombre de la escuela
        $sql_nombre_escuela = $conexion->prepare("SELECT * FROM establecimiento_educativo WHERE CUE = ?");
        $sql_nombre_escuela->bind_param("s", $usuario);
        $sql_nombre_escuela->execute();
        $result = $sql_nombre_escuela->get_result();

        //estudiantes habilitados
        $sql_datos_habilitados_esc = $conexion->prepare("SELECT * FROM estudiante WHERE estado_credencial = ? AND establecimiento_educativo = ?");
        $estado_hab = "habilitado";
        $sql_datos_habilitados_esc->bind_param("ss", $estado_hab, $usuario);
        $sql_datos_habilitados_esc->execute();
        $result_hab_esc = $sql_datos_habilitados_esc->get_result();
        $alumnos_hab_user = $result_hab_esc->num_rows;

        //estudiantes por habilitar de la escuela
        $sql_datos_no_habilitados = $conexion->prepare("SELECT * FROM estudiante WHERE estado_credencial = ?");
        $estado_no_hab = "espera_escuela";
        $sql_datos_no_habilitados->bind_param("s", $estado_no_hab);
        $sql_datos_no_habilitados->execute();
        $result_no_hab = $sql_datos_no_habilitados->get_result();
        $alumnos_no_hab = $result_no_hab->num_rows;



        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $response['status'] = 'success';
            $response['establecimiento_educativo'] = $row['establecimiento_educativo'];
            $response['habilitados_user'] = $alumnos_hab_user;
            $response['habilitados'] = $alumnos_hab;
            $response['no_habilitados'] = $alumnos_no_hab;
        }else {
            $response['status'] = 'error';
            $response['message'] = 'Sesión no iniciada';
        }

        
        header("Content-Type: application/json");
        echo json_encode($response);
    }


?>