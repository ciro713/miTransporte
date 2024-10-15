<?php
include('../config/db-connection.php');

$DNI = $_POST['id_borrar'];

// Iniciar una transacción para asegurar consistencia en las eliminaciones
mysqli_begin_transaction($conexion);

try {
    // Obtener el id_estudiante usando el DNI
    $query_get_id = "SELECT id_estudiante FROM estudiante WHERE DNI = ?";
    $stmt_get_id = $conexion->prepare($query_get_id);
    $stmt_get_id->bind_param("i", $DNI);
    $stmt_get_id->execute();
    $result_get_id = $stmt_get_id->get_result();
    
    if ($result_get_id->num_rows > 0) {
        $row = $result_get_id->fetch_assoc();
        $id_estudiante = $row['id_estudiante'];

        // Eliminar de estudiantes_cooperativas primero
        $query_delete_relations = "DELETE FROM estudiantes_cooperativas WHERE id_estudiante = ?";
        $stmt_delete_relations = $conexion->prepare($query_delete_relations);
        $stmt_delete_relations->bind_param("i", $id_estudiante);
        $stmt_delete_relations->execute();

        // Eliminar de estudiante
        $query_delete_student = "DELETE FROM estudiante WHERE DNI = ?";
        $stmt_delete_student = $conexion->prepare($query_delete_student);
        $stmt_delete_student->bind_param("i", $DNI);
        $stmt_delete_student->execute();

        // Eliminar de usuarios
        $query_delete_user = "DELETE FROM usuarios WHERE usuario = ?";
        $stmt_delete_user = $conexion->prepare($query_delete_user);
        $stmt_delete_user->bind_param("i", $DNI);
        $stmt_delete_user->execute();

        // Confirmar la transacción si todo va bien
        mysqli_commit($conexion);
        echo "Estudiante, relaciones y usuario eliminados exitosamente.";
        echo "1";
    } else {
        echo "No se encontró un estudiante con el DNI proporcionado.";
        echo "0";
    }
} catch (Exception $e) {
    // En caso de error, revertir la transacción
    mysqli_rollback($conexion);
    echo "Error al eliminar: " . $e->getMessage();
    echo "0";
}


?>