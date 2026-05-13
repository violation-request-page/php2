<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'Exception.php';
require 'PHPMailer.php';
require 'SMTP.php';

$mail = new PHPMailer(true);

try {
    // Brevo SMTP Settings jo aapne di hain
    $mail->isSMTP();
    $mail->Host       = 'smtp-relay.brevo.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'progemni7@gmail.com'; 
    $mail->Password   = 'xsmtpsib-a7511f46cc34624fd866b971d375c5db7d4504116a5633c5ce90d56d23872346-RwGe4vf7NfXet8Nw'; 
    $mail->Port       = 587;
    $mail->SMTPSecure = 'tls'; 

    // Email Details
    $mail->setFrom('arzajejo@arzajejo.xyz', 'Arzajejo Website');
    $mail->addAddress('progemni7@gmail.com'); 

    $mail->isHTML(true);
    $mail->Subject = 'New Submission from ' . $_POST['email'];
    $mail->Body    = "<h3>New Message Received</h3>
                      <p><strong>Email:</strong> {$_POST['email']}</p>
                      <p><strong>Message:</strong> {$_POST['message']}</p>";

    $mail->send();
    echo "Success: Email has been sent!";
} catch (Exception $e) {
    echo "Error: Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
