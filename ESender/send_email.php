<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

header('Content-Type: application/json');

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'surgicommail@gmail.com';
    $mail->Password = 'onlixmeximoohmzh';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Set sender
    $mail->setFrom('surgicommail@gmail.com', 'Mailer');

    // Recipients
    $recipients = explode(',', $_POST['recipients']);
    foreach ($recipients as $recipient) {
        $recipient = trim($recipient); // Trimming whitespace around email addresses
        $mail->clearAddresses(); // Clear previous addresses
        $mail->addAddress($recipient); // Add current recipient
        // Attachments (if needed)
        if (!empty($_FILES['attachment']['name'])) {
            $mail->addAttachment($_FILES['attachment']['tmp_name'], $_FILES['attachment']['name']);
        }
        // Content
        $mail->isHTML(true);
        $mail->Subject = $_POST['subject'];
        $mail->Body    = $_POST['body'];
        $mail->AltBody = strip_tags($_POST['body']);
        $mail->send(); // Send email
        // Optional: Logging
        // echo "Email sent to: $recipient\n";
    }

    echo json_encode(['message' => 'Emails have been sent successfully!']);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => "Message could not be sent. Mailer Error: {$mail->ErrorInfo}"]);
}
