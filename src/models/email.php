<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
function enviarCorreo($from, $name, $address, $subject, $body) {
    $mail = new PHPMailer(true);
    $respuesta = new stdclass;

    try {
        // Configuración del servidor
        $mail->isSMTP();
        $mail->Host = 'smtp.office365.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'facundoaragon05@hotmail.com';
        $mail->Password = 'cadufacu7';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        // Destinatarios from= remitente, 
        $mail->setFrom($from, $name);
        $mail->addAddress($address);
    
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $body;
    
        $mail->send();
        // echo 'El mensaje ha sido enviado';
        $respuesta->ok = true;
        return $respuesta;
    } catch (Exception $e) {
        $respuesta->ok = false;
        $respuesta->mensaje = "El mensaje no pudo ser enviado. Error de Mailer: {$mail->ErrorInfo}";
        return $respuesta;
    }

} 


?>