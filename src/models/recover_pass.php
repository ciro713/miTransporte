<?php
    include('../config/db-connection.php');

    $DNI = $_POST['dni'];
        echo "DNI recibido: " . $DNI; // Mostrar el DNI para depuración
        
        // Verificar si el usuario existe en la base de datos
        $sql_email_alumno = $conexion->prepare("SELECT email FROM estudiante WHERE DNI = ?");
        $sql_email_alumno->bind_param('s', $DNI);
        $sql_email_alumno->execute();
        
        $result_sql_email_alumno = $sql_email_alumno->get_result();
        $user = $result_sql_email_alumno->fetch_assoc();

        $address = $user['email'];
        echo "email a enviar: " . $address;

        // Generar un token único para el enlace de recuperación
        $token = bin2hex(random_bytes(32));
        
        // Establecer la fecha de expiración (1 hora a partir de ahora)
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));

        // Insertar o actualizar el token en la base de datos
        $sql_insert_token = $conexion->prepare(
            "INSERT INTO password_resets (DNI, token, created_at, expires_at) 
            VALUES (?, ?, NOW(), ?) 
            ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)"
        );
        $sql_insert_token->bind_param('sss', $DNI, $token, $expiresAt);
        $sql_insert_token->execute();

        // Construir el enlace de recuperación
        $resetLink = "http://localhost/miTransporte/public/reset_pass.php?token=" . $token;

        // Incluir el archivo para enviar el correo
        include("./email.php");
        $response = enviarCorreo(
            "facundoaragon05@hotmail.com",
            "miTransporte",
            $user['email'],
            "Su credencial ha sido habilitada",
            "
            <h1 style='text-align: center;'>miTransporte</h1>
            <img src='https://www.tecnica1lacosta.edu.ar/mitransporte/public/img/logo.png' alt='Logo' />
            <h3 style='text-align: center;'>Su credencial ha sido habilitada, ya está apto para poder iniciar sesión y utilizar su credencial</h3>
            <h4 style='text-align: center;'>¡Gracias por su espera!</h4>
            <h4 style='text-align: center;'>¡Visita nuestra página web!</h4>
            <center>
            <a href='https://www.tecnica1lacosta.edu.ar/mitransporte/' style='background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px; align-items: center'>Ingresar</a>
            </center>
            <footer style='text-align: center; font-size: 12px; color: #777;'>
                <p>© 2024 miTransporte. Todos los derechos reservados.</p>
            </footer>
            "
        );

        /*$subject = "Reestablecer Contraseña - miTransporte";
        $body = "
            <h1 style='text-align: center;'>miTransporte</h1>
            <img src='https://www.tecnica1lacosta.edu.ar/mitransporte/public/img/logo.png' alt='Logo' />
            <h3 style='text-align: center;'>Haz solicitado reestablecer tu contraseña</h3>
            <p style='text-align: center;'>Haz clic en el siguiente enlace para reestablecer tu contraseña:</p>
            <center>
            <a href='" . $resetLink . "' style='background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;'>Reestablecer Contraseña</a>
            </center>
            <p style='text-align: center;'>Si no solicitaste un cambio de contraseña, ignora este correo.</p>
            <footer style='text-align: center; font-size: 12px; color: #777;'>
                <p>© 2024 miTransporte. Todos los derechos reservados.</p>
            </footer>
        ";

        // Enviar el correo electrónico
        $response = enviarCorreo(
            $from = "facundoaragon05@hotmail.com", // Remitente
            $name = "miTransporte",                // Nombre del remitente
            $address,                        // Destinatario
            $subject,                      // Asunto
            $body                          // Cuerpo del correo
        );*/


        /* Contenido del correo electrónico
                $respuesta = enviarCorreo(
            "facundoaragon05@hotmail.com",
            "miTransporte",
            $email,
            "Reestablecer Contraseña - miTransporte",
            "
            <h1 style='text-align: center;'>miTransporte</h1>
            <img src='https://www.tecnica1lacosta.edu.ar/mitransporte/public/img/logo.png' alt='Logo' />
            <h3 style='text-align: center;'>Haz solicitado reestablecer tu contraseña</h3>
            <p style='text-align: center;'>Haz clic en el siguiente enlace para reestablecer tu contraseña:</p>
            <center>
            <a href='" . $resetLink . "' style='background-color: #007bff; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px;'>Reestablecer Contraseña</a>
            </center>
            <p style='text-align: center;'>Si no solicitaste un cambio de contraseña, ignora este correo.</p>
            <footer style='text-align: center; font-size: 12px; color: #777;'>
                <p>© 2024 miTransporte. Todos los derechos reservados.</p>
            </footer>
            "
        );
        */

        if ($response->ok) {
            echo json_encode(['success' => true, 'message' => 'Correo enviado con éxito']);
            return;
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al enviar el correo']);
            return;
        }


?>