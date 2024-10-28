<?php
    include('../config/db-connection.php');
    include('../config/sesion.php');

    $new_password = $conexion->real_escape_string($_POST['new_password']);

    // Verificar la longitud de la nueva contraseña
    if (strlen($new_password) < 8) {
        echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres.']);
        exit();
    }else{
        $id_usuario = $_SESSION['id_usuario'];

        // Encriptar la nueva contraseña usando PASSWORD_DEFAULT
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

        // Actualizar la contraseña en la base de datos
        $sql_update_password = $conexion->prepare("UPDATE usuarios SET `password` = ? WHERE `id_usuario` = ?");
        $sql_update_password->bind_param('ss', $hashed_password, $id_usuario);

        if ($sql_update_password->execute()) {
            echo json_encode(['success' => true, 'message' => 'Contraseña reestablecida con éxito.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña.']);
        }
    }


?>