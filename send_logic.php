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
    
    // 1. Timezone set karein (Pakistan ke liye 'Asia/Karachi')
    date_default_timezone_set('Asia/Karachi'); 
    
    // 2. Request ka time nikalen
    $request_time = $_SERVER['REQUEST_TIME']; // Timestamp jab request server pr aayi
    $current_time = time(); // Abhi ka mojuda time
    
    // 3. Agar request 1 ghante (3600 seconds) se zyada purani hai, toh email mat bhejo
    if (($current_time - $request_time) > 3600) {
        echo "success"; // JavaScript ko success bol den taake error na aaye, lekin email skip ho jaye
        exit;
    }

    $mail = new PHPMailer(true);

    try {
        // Brevo SMTP Settings
        $mail->isSMTP();
        $mail->Host       = 'smtp-relay.brevo.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ab2b68001@smtp-brevo.com'; 
        $mail->Password   = 'bsknvfTPYzK3DVt'; 
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
        // Email mein time bhi add kar dete hain taake confirm ho sake
        $message_body .= "<b>Submitted At:</b> " . date('Y-m-d H:i:s', $request_time) . "<br><br>";

        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $message_body .= "<b>" . ucfirst($key) . ":</b> " . htmlspecialchars($value) . "<br>";
            }
        } else {
            $message_body .= "No data fields captured. Check JavaScript payload.";
        }

        $mail->Body = $message_body;

        $mail->send();
        echo "success"; 
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Direct access not allowed.";
}
?>
