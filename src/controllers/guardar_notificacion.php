<?php
    include('../config/db-connection.php');
    include('../config/sesion.php');

    $id_usuario = $_SESSION['id_usuario'];

    // Obtener el ID de la cooperativa del usuario actual
    $cooperativa_query = $conexion->query("SELECT u.usuario, c.id_cooperativa, c.email FROM usuarios u INNER JOIN cooperativa c ON u.usuario = c.email WHERE u.usuario = '$id_usuario'");
    $cooperativa_resultado = $cooperativa_query->fetch_assoc();
    $id_cooperativa = $cooperativa_resultado['id_cooperativa'];

    $titulo = $conexion->real_escape_string($_POST['titulo']);
    $contenido = $conexion->real_escape_string($_POST['contenido']);

    function enviarNotificacion($id_cooperativa, $titulo, $contenido) {
        $ch = curl_init();
    
        curl_setopt($ch, CURLOPT_URL, "https://fa31aad8-8331-4a42-ada3-dc5d41161c7f.pushnotifications.pusher.com/publish_api/v1/instances/fa31aad8-8331-4a42-ada3-dc5d41161c7f/publishes");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([
            "interests" => ["cooperativa_" . $id_cooperativa],
            "web" => [
                "notification" => [
                    "title" => $titulo,
                    "body" => $contenido
                ]
            ]
        ]));
    
        $headers = [];
        $headers[] = "Content-Type: application/json";
        $headers[] = "Authorization: Bearer DC70D845E43AAF3D475ED058FA1FE37BFD4253FA76A222859B4727737B304F53";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:' . curl_error($ch);
        }
        curl_close($ch);
    
        return $result;
    }

    // Insertar la notificación en la base de datos
    $sql_insertar_notificacion = "INSERT INTO notificaciones (id_cooperativa, titulo, mensaje, fecha) VALUES ('$id_cooperativa', '$titulo', '$contenido', NOW())";
    $conexion->query($sql_insertar_notificacion);

    // Enviar la notificación usando Pusher
    enviarNotificacion($id_cooperativa, $titulo, $contenido);

    echo "Notificación enviada exitosamente";
?>