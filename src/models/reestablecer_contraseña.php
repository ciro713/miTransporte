<?php
include('../config/db-connection.php');
header('Content-Type: application/json');

// Obtener datos del POST
$token = $conexion->real_escape_string($_POST['token']);
$new_password = $conexion->real_escape_string($_POST['new_password']);

/*if (strlen($new_password) < 8) {
    echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 8 caracteres.']);
    exit();
}*/

// Obtener el DNI asociado al token
$sql_get_dni = $conexion->prepare("SELECT DNI FROM password_resets WHERE token = ? AND expires_at > NOW()");
$sql_get_dni->bind_param('s', $token);
$sql_get_dni->execute();
$result = $sql_get_dni->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $DNI = $row['DNI'];

    // Encriptar la nueva contraseña usando PASSWORD_DEFAULT
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // Actualizar la contraseña en la base de datos
    $sql_update_password = $conexion->prepare("UPDATE estudiante SET password = ? WHERE DNI = ?");
    $sql_update_password->bind_param('ss', $hashed_password, $DNI);

    if ($sql_update_password->execute()) {
        // Eliminar el token una vez usado
        $sql_delete_token = $conexion->prepare("DELETE FROM password_resets WHERE token = ?");
        $sql_delete_token->bind_param('s', $token);
        $sql_delete_token->execute();
        

        echo json_encode(['success' => true, 'message' => 'Contraseña reestablecida con éxito.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la contraseña.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Token inválido o expirado.']);
}
?>