<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

function enviarCorreo($from, $name, $address, $subject, $body) {
    $mail = new PHPMailer(true);
    $respuesta = new stdClass;

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'leaguenet7@gmail.com'; 
        $mail->Password = 'kvns qlot jbvp yivd';  
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Activar modo de depuración
        $mail->SMTPDebug = 2; // Nivel de depuración
        $mail->Debugoutput = 'html';

        // Destinatarios
        $mail->setFrom($from, $name);
        $mail->addAddress($address);

        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;

        // Enviar correo
        $mail->send();
        $respuesta->ok = true;
        return $respuesta;
    } catch (Exception $e) {
        $respuesta->ok = false;
        $respuesta->mensaje = "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
        echo "Mailer Error: " . $mail->ErrorInfo; // Para depuración
        return $respuesta;
    }
}
 
?>