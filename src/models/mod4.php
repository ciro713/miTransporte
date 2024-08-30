<?php
include('../config/db-connection.php');
include('../config/sesion.php');

$id_usuario = $_SESSION['id_usuario'];

// Obtener el ID de la cooperativa del usuario actual
$cooperativa_query = $conexion->query("SELECT u.usuario, c.id_cooperativa, c.email FROM usuarios u INNER JOIN cooperativa c ON u.usuario = c.email WHERE u.usuario = '$id_usuario'");
$cooperativa_resultado = $cooperativa_query->fetch_assoc();
$id_cooperativa = $cooperativa_resultado['id_cooperativa'];

if (isset($_POST['id_confirmar'])) {
    $DNI = $_POST['id_confirmar'];

    // Actualizar el estado en la tabla estudiantes_cooperativas
    $update_relation_query = "UPDATE estudiantes_cooperativas ec INNER JOIN estudiante e ON ec.id_estudiante = e.id_estudiante SET ec.estado = 'habilitado' WHERE e.DNI = ? AND ec.id_cooperativa = ?";
    $stmt_update_relation = $conexion->prepare($update_relation_query);
    $stmt_update_relation->bind_param('si', $DNI, $id_cooperativa);
    $stmt_update_relation->execute();

    // Verificar si todas las cooperativas relacionadas están habilitadas
    $check_all_habilitated_query = "SELECT COUNT(*) AS count FROM estudiantes_cooperativas ec INNER JOIN estudiante e ON ec.id_estudiante = e.id_estudiante WHERE e.DNI = ? AND ec.estado != 'habilitado'";
    $stmt_check_all_habilitated = $conexion->prepare($check_all_habilitated_query);
    $stmt_check_all_habilitated->bind_param('s', $DNI);
    $stmt_check_all_habilitated->execute();
    $result_check_all_habilitated = $stmt_check_all_habilitated->get_result();
    $row = $result_check_all_habilitated->fetch_assoc();

    if ($row['count'] == 0) {
       // Si todas las cooperativas están habilitadas, actualizar el estado_credencial
        $update_student_query = "UPDATE estudiante SET estado_credencial = 'habilitado' WHERE DNI = ?";
        $stmt_update_student = $conexion->prepare($update_student_query);
        $stmt_update_student->bind_param('s', $DNI);
        $stmt_update_student->execute();

        include("./email.php");
        $response = enviarCorreo(
            "facundoaragon05@hotmail.com",
            "miTransporte",
            "anachuchu309@gmail.com",
            "Su credencial ha sido habilitada",
        
            "
        
            <h1 style='text-align: center;'>miTransporte</h1>
            <img src='https://www.tecnica1lacosta.edu.ar/mitransporte/public/img/logo.png' alt='Logo' />
            <h3 style='text-align: center;'>Su credencial ha sido habilitada, ya está apto para poder iniciar sesión y utilizar su credencial</h3>
            <h4 style='text-align: center;'>¡Gracias por su espera!</h4>
            <h4 style='text-align: center;'>¡Visita nuestra pagina web!</h4>
            <center>
            <a href='https://www.tecnica1lacosta.edu.ar/mitransporte/' style='background-color: #007bff; color: white; padding: 10px 20px; 
                text-decoration: none; display: inline-block; border-radius: 5px; align-items: center'>Ingresar</a>
            </center>
            <footer style='text-align: center; font-size: 12px; color: #777;'>
                <p>© 2024 miTransporte. Todos los derechos reservados.</p>
            </footer>
            
            "
        );

        if($response->ok) {
            //echo json_encode(["ok" => true, "message" => "Oka"]);
            echo '1 ';
            return;
        }
        echo json_encode(["ok" => false, "message" => "Ha ocurrido un error"]);
        return;

        include("ejemploCorreo.php");
    }

    // Verificar si la operación fue exitosa
    if ($stmt_update_relation->affected_rows > 0) {
        echo '1';
    } else {
        echo '0';
    }


    
} else {
    echo 'No se recibió ningún ID';
}
?>
