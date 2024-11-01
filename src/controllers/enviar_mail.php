<?php
    include('../config/db-connection.php');

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Allow-Headers: Content-Type");

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;


    //..\models\

    function token(){
        $r1 = bin2hex(random_bytes(1));
        $r2 = bin2hex(random_bytes(1));
        $r3 = bin2hex(random_bytes(1));
        $r4 = bin2hex(random_bytes(1));
    
        $token = $r1.'-'.$r2.'-'.$r3.'-'.$r4;
    
        return $token;
    }

    //$opcion = $conexion->real_escape_string($_POST['opcion']); 

    $cue_escuela = $conexion->real_escape_string($_POST['CUEmodal']);

    /*$establecimiento_query = $conexion->query("SELECT `email` FROM `establecimiento_educativo` WHERE `CUE` = $cue_escuela");
    $establecimiento_resultado = $establecimiento_query->fetch_assoc();
    $email_establecimiento = $establecimiento_resultado['email'];*/
    //$establecimiento_educativo = $establecimiento_resultado['establecimiento_educativo'];

    $token_enviar = token();

    $sql_update_token = $conexion->prepare("UPDATE `establecimiento_educativo` SET token = (?) WHERE CUE = (?)");
    $sql_update_token->bind_param('ss', $token_enviar, $cue_escuela);
    $sql_update_token->execute();

    require '../models/PHPMailer/Exception.php';
    require '../models/PHPMailer/PHPMailer.php';
    require '../models/PHPMailer/SMTP.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    $respuesta_email = array('error' => true, 'mensaje' => 'error anterior al envio del email');

    try {
        //Server settings
        $mail->SMTPDebug = 0;                      //Enable verbose debug output SMTP::DEBUG_SERVER
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'sandbox.smtp.mailtrap.io';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = '4e464c506ad3da';                     //SMTP username
        $mail->Password   = '236a1777d069c4';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $mail->Port       = 2525;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('cirolazarte713@gmail.com', 'MiTransporte');
        $mail->addAddress(/*$email_establecimiento*/'ciroandres1310@gmail.com'/*, $establecimiento_educativo*/);     //Add a recipient

        /*//Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name*/


        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'prueba de email';
        $mail->Body    = 'ingrese el token para poder cambiar la contraseña<br>token: <b>'.$token_enviar.'</b><br>escuela:'.$cue_escuela.'';
        //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
        //echo 'enviado correctamente';
        $respuesta_email = array('enviado' => true);
    } catch (Exception $e) {
        //echo "error al enviar: {$mail->ErrorInfo}";
        $respuesta_email = array('error' => true, 'mensaje' => 'no se envio el email');
    }

    header("Content-Type: application/json");
    echo json_encode($respuesta_email);
    exit();

?>