<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Cambia esto a tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'tu_correo@example.com';
        $mail->Password = 'tu_contraseña';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom('tu_correo@example.com', 'Tu Nombre');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Confirmación de Recepción de Correo';
        $mail->Body    = 'Hemos recibido tu correo electrónico. En breve, procederemos con el proceso de habilitación.';

        $mail->send();

        echo 'El mensaje de confirmación ha sido enviado';
        
        // Llamar a la función que habilita credenciales y envía el segundo correo
        habilitarCredenciales($email);
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
    }
}

function habilitarCredenciales($email) {
    // Aquí puedes implementar la lógica para habilitar credenciales
    // Por ejemplo, actualizar la base de datos, etc.

    // Después de habilitar las credenciales, enviar el correo de notificación
    enviarCorreoDeNotificacion($email);
}

function enviarCorreoDeNotificacion($email) {
    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com'; // Cambia esto a tu servidor SMTP
        $mail->SMTPAuth = true;
        $mail->Username = 'tu_correo@example.com';
        $mail->Password = 'tu_contraseña';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Destinatarios
        $mail->setFrom('tu_correo@example.com', 'Tu Nombre');
        $mail->addAddress($email);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Credencial Habilitada';
        $mail->Body    = 'Tu credencial ha sido habilitada y está lista para usar.';

        $mail->send();

        echo 'El mensaje de notificación ha sido enviado';
    } catch (Exception $e) {
        echo "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
    }
}
?>
