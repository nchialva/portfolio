<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = strip_tags(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = strip_tags(trim($_POST['subject']));
    $message = strip_tags(trim($_POST['message']));

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'nicolaschialva82@gmail.com'; 
        $mail->Password   = 'uqew xwmr skrq unsm';       
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Destinatario
        $mail->setFrom('nicolaschialva82@gmail.com', 'Nicolas Chialva');
        $mail->addAddress('nicolaschialva82@gmail.com', 'Nicolas Chialva'); 

        // Contenido
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = "<strong>Nombre:</strong> $name<br>
                          <strong>Email:</strong> $email<br>
                          <strong>Mensaje:</strong><br>$message";

        $mail->send();
        echo json_encode(['status'=>'success', 'message'=>'Mensaje enviado correctamente']);
    } catch (Exception $e) {
        echo json_encode(['status'=>'error', 'message'=>"No se pudo enviar el mensaje. Error: {$mail->ErrorInfo}"]);
    }
}
?>