<?php
    require('../config/sesion.php');
    include('../config/db-connection.php');

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

// Permitir solicitudes desde cualquier origen
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

$opcion = $conexion->real_escape_string($_POST['opcion']);

switch($opcion){
    case 'ingresar':
        $id_usuario = $conexion->real_escape_string($_POST['id_usuario']);
        $password = $conexion->real_escape_string($_POST['password']);
    
        $sql_estudiante = $conexion->query("SELECT u.usuario, u.password, e.DNI, e.nombre_apellido FROM usuarios u INNER JOIN estudiante e ON u.usuario = e.DNI WHERE u.usuario = '$id_usuario'");
    
        $sql_establecimiento = $conexion->query("SELECT u.usuario, u.password, ee.CUE, ee.establecimiento_educativo FROM usuarios u INNER JOIN establecimiento_educativo ee ON u.usuario = ee.CUE WHERE u.usuario = '$id_usuario'");
        //$sql_establecimiento = $conexion->query("SELECT u.id_usuario, u.password, ee.CUE, ee.establecimiento_educativo FROM usuarios u INNER JOIN establecimiento_educativo ee ON u.id_usuario = ee.CUE WHERE u.id_usuario = '$id_usuario'");
    
        $sql_cooperativa = $conexion->query("SELECT u.usuario, u.password, c.cooperativa, c.cooperativa FROM usuarios u INNER JOIN cooperativa c ON u.usuario = c.email WHERE u.usuario = '$id_usuario'");
        //$sql_cooperativa = $conexion->query("SELECT u.id_usuario, u.password, c.id_cooperativa, c.cooperativa FROM usuarios u INNER JOIN cooperativa c ON u.id_usuario = c.email WHERE u.id_usuario = '$id_usuario'");
    
        $acceso = array('invalido' => true);
    
        if ($datos_estudiante = $sql_estudiante->fetch_object()) {
            $estado_query = $conexion->query("SELECT estado_credencial FROM estudiante WHERE DNI = '$id_usuario'");
            $hash_guardado = $datos_estudiante->password;
    
            if (password_verify($password, $hash_guardado)) {
                $estado_row = $estado_query->fetch_assoc();

                $_SESSION['id_usuario'] = $id_usuario;
    
                if ($estado_row){
                    $estado = $estado_row['estado_credencial'];
    
                    switch($estado){
                        case 'habilitado':
                            $acceso['habilitado'] = true;
                        break;
    
                        case 'espera_escuela':
                        case 'espera_cooperativa':
                            $acceso['espera'] = true;
                        break;
                    }
                }
            }
    
        }else if($datos_establecimiento = $sql_establecimiento->fetch_object()){
            $hash_guardado = $datos_establecimiento->password;
    
            if(password_verify($password, $hash_guardado)) {
                if(password_verify($id_usuario,$hash_guardado)){
                    $acceso = array('cambiar' => true, 'mensaje' => 'cambiar password');
                }else{
                    $acceso['escuela'] = true;
                    $_SESSION['id_usuario'] = $id_usuario;
                    $_SESSION['rol'] = "escuela";
                    // La contraseña es válida
                }

            } else {
                // Contraseña incorrecta
                $acceso = array('escuelafallido' => true, 'mensaje' => 'password incorrecto');
            }
        } else if($datos_cooperativa = $sql_cooperativa->fetch_object()){
            
            $hash_guardado = $datos_cooperativa->password;
    
            if (password_verify($password, $hash_guardado)) {
                $acceso['cooperativa'] = true;
                $_SESSION['id_usuario'] = $id_usuario;
                $_SESSION['rol'] = "cooperativa";
                // La contraseña es válida
            }
        }

        header("Content-Type: application/json");
        echo json_encode($acceso);
        exit();
    
    break;
    

    case 'registrarse':

        $response = array();

        try {
            // Verificar conexión a la base de datos
            if (!$conexion) {
                throw new Exception('Error en la conexión a la base de datos.');
            }

            // Recibir y limpiar datos del formulario
            $nombre_apellido = $conexion->real_escape_string($_POST['nombre_apellido']);
            $password = $conexion->real_escape_string($_POST['password']);
            $DNI = $conexion->real_escape_string($_POST['id_usuario']);
            $establecimiento_educativo = $conexion->real_escape_string($_POST['establecimiento_educativo']);
            $desde = $conexion->real_escape_string($_POST['desde']);
            $hasta = $conexion->real_escape_string($_POST['hasta']);
            $direccion = $conexion->real_escape_string($_POST['direccion']);
            $email = $conexion->real_escape_string($_POST['email']);

            // Obtener las cooperativas seleccionadas
            $colectivos = isset($_POST['colectivos']) ? $_POST['colectivos'] : [];

            // Verificar duplicados
            $sql_comprobar_duplicado = $conexion->query("SELECT u.usuario, e.DNI FROM usuarios u INNER JOIN estudiante e ON u.usuario = e.DNI WHERE u.usuario = '$DNI'");

            if ($datos_duplicado = $sql_comprobar_duplicado->fetch_object()) {
                $response = array('duplicado' => true);
            } else {
                $password = password_hash($password, PASSWORD_DEFAULT); // Encriptar la contraseña

                $uploadDir = '../uploads/';

                // Verificar si se cargaron correctamente las imágenes antes de moverlas
                if (
                    isset($_FILES['img_documento_frente']) && $_FILES['img_documento_frente']['error'] === UPLOAD_ERR_OK &&
                    isset($_FILES['img_documento_reverso']) && $_FILES['img_documento_reverso']['error'] === UPLOAD_ERR_OK &&
                    isset($_FILES['img_estudiante']) && $_FILES['img_estudiante']['error'] === UPLOAD_ERR_OK &&
                    isset($_FILES['img_constancia_alumno']) && $_FILES['img_constancia_alumno']['error'] === UPLOAD_ERR_OK
                ) {
                    $imagen1Path = $uploadDir . basename($_FILES['img_documento_frente']['name']);
                    $imagen2Path = $uploadDir . basename($_FILES['img_documento_reverso']['name']);
                    $imagen3Path = $uploadDir . basename($_FILES['img_estudiante']['name']);
                    $imagen4Path = $uploadDir . basename($_FILES['img_constancia_alumno']['name']);

                    if (
                        move_uploaded_file($_FILES['img_documento_frente']['tmp_name'], $imagen1Path) &&
                        move_uploaded_file($_FILES['img_documento_reverso']['tmp_name'], $imagen2Path) &&
                        move_uploaded_file($_FILES['img_estudiante']['tmp_name'], $imagen3Path) &&
                        move_uploaded_file($_FILES['img_constancia_alumno']['tmp_name'], $imagen4Path)
                    ) {
                        // Verificar existencia de usuario
                        $sql_verificar = $conexion->prepare("SELECT * FROM usuarios WHERE id_usuario = ?");
                        $sql_verificar->bind_param('s', $DNI);
                        $sql_verificar->execute();
                        $sql_verificar_result = $sql_verificar->get_result();

                        if ($sql_verificar_result->num_rows > 0) {
                            $response = array('fallido' => true, 'mensaje' => 'El usuario ya existe.');
                        } else {
                            // Insertar en la tabla estudiante
                            $sql_insertar_estudiante = $conexion->prepare("INSERT INTO estudiante (DNI, nombre_apellido, email, direccion, desde, hasta, establecimiento_educativo, img_documento_frente, img_documento_reverso, img_estudiante, img_constancia_alumno, estado_credencial) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'espera_escuela')");
                            $sql_insertar_estudiante->bind_param('sssssssssss', $DNI, $nombre_apellido, $email, $direccion, $desde, $hasta, $establecimiento_educativo, $imagen1Path, $imagen2Path, $imagen3Path, $imagen4Path);
                            $sql_insertar_estudiante->execute();

                            //obtener el id del estudiante
                            $id_estudiante = $sql_insertar_estudiante->insert_id;

                            // Insertar en la tabla usuarios
                            $sql_insertar_usuario = $conexion->prepare("INSERT INTO usuarios (`usuario`, `password`) VALUES (?, ?)");
                            $sql_insertar_usuario->bind_param('ss', $DNI, $password);
                            $sql_insertar_usuario->execute();

                            //relaciones estudiante_colectivo
                            $sql_insertar_relacion_colectivo = $conexion->prepare("INSERT INTO estudiantes_cooperativas (id_estudiante, id_cooperativa, estado) VALUES (?, ?, 'espera')");

                            foreach ($colectivos as $cooperativa_id) {
                                $sql_insertar_relacion_colectivo->bind_param('ii', $id_estudiante, $cooperativa_id);
                                $sql_insertar_relacion_colectivo->execute();
                            }

                            if ($sql_insertar_estudiante->affected_rows > 0 && $sql_insertar_usuario->affected_rows > 0) {
                                $response = array('exito' => true);
                            } else {
                                throw new Exception('Error al insertar en la tabla estudiantes o usuarios.');
                            }
                        }
                    } else {
                        throw new Exception('Error al subir las imágenes.');
                    }
                } else {
                    throw new Exception('Error al cargar las imágenes.');
                }
            }
        } catch (Exception $e) {
            $response = array('fallido' => true, 'mensaje' => $e->getMessage());
        }

        // Enviar respuesta como JSON
        echo json_encode($response);
        exit();
        break;
    }
    $conexion->close();
?>