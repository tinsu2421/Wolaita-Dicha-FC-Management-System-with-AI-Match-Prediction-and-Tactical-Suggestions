<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

error_reporting(E_ALL);
ini_set('display_errors', 1);
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'MailerSrc/PHPMailer/src/Exception.php';
require 'MailerSrc/PHPMailer/src/PHPMailer.php';
require 'MailerSrc/PHPMailer/src/SMTP.php';

if (isset($_POST['SubmitContacQuery'])) {

    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);

    try {
        // 1. Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rediettesfaye09@gmail.com'; // ADMIN EMAIL
        $mail->Password   = 'lmgi zmbe krkt gfte';       // APP PASSWORD
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        // 2. Sender & Receiver
        $mail->setFrom($email, $name);
        $mail->addAddress('rediettesfaye09@gmail.com'); // Admin receives here

        // 3. Content
        $mail->isHTML(true);
        $mail->Subject = 'New Contact Message - Wolaita Dicha FC';
        $mail->Body    = "
            <h3>New Contact Message</h3>
            <p><b>Name:</b> $name</p>
            <p><b>Email:</b> $email</p>
            <p><b>Message:</b><br>$message</p>
        ";

        $mail->send();

        echo "<script>alert('Message sent successfully!'); window.location.href='index.php#contact';</script>";

    } catch (Exception $e) {
        echo "Message could not be sent. Error: {$mail->ErrorInfo}";
    }
}
?>
