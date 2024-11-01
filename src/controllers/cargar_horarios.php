<?php
    include('../config/db-connection.php');
    include('../config/sesion.php');

    $id_usuario = $_SESSION['id_usuario'];

    // Obtener el ID de la cooperativa del usuario actual
    $cooperativa_query = $conexion->query("SELECT u.usuario, c.id_cooperativa, c.email FROM usuarios u INNER JOIN cooperativa c ON u.usuario = c.email WHERE u.usuario = '$id_usuario'");
    $cooperativa_resultado = $cooperativa_query->fetch_assoc();
    $id_cooperativa = $cooperativa_resultado['id_cooperativa'];

    $tipo = $_POST['horario_tipo'];

    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/horarios/';
        
       // Generar el nuevo nombre del archivo
       $newFileName = "horario_" . $tipo . "_cooperativa_" . $id_cooperativa . ".pdf";
       $filePath = $uploadDir . $newFileName;

       if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
           // Guardar la URL en la base de datos
           $url = $filePath;
           $sql = $conexion->prepare("UPDATE horarios SET url = ? WHERE id_cooperativa = ? AND horario = ?");
           $sql->bind_param('sis', $url, $id_cooperativa, $tipo);

           if ($sql->execute()) {
               echo json_encode(['success' => true]);
           } else {
               echo json_encode(['success' => false, 'message' => 'Error al guardar en la base de datos.']);
           }
       } else {
           echo json_encode(['success' => false, 'message' => 'Error al mover el archivo.']);
       }
   } else {
       echo json_encode(['success' => false, 'message' => 'Error al cargar el archivo.']);
   }
?>

