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
        // --- RESEND SMTP SETTINGS ---
        $mail->isSMTP();
        $mail->Host       = 'smtp.resend.com';                // Resend ka SMTP Host
        $mail->SMTPAuth   = true;
        $mail->Username   = 'resend';                         // Ye hamesha 'resend' hi rahega (small letters mein)
        $mail->Password   = 're_GdTNpKbH_CdEP68a1X7bNTz3BcuNAXf3M';                // <-- Yahan apni Resend se bani hui API Key paste karein
        $mail->Port       = 465;                              // Resend ke liye 465 port behtar hai
        $mail->SMTPSecure = 'ssl';                            // 465 ke sath 'ssl' use hota hai

        // Sender & Receiver
        // Note: setFrom mein wahi email use karein jo aapke verified domain (arzajejo.xyz) par ho
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
