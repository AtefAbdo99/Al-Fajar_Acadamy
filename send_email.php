<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = filter_var($_POST["name"], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST["email"], FILTER_SANITIZE_EMAIL);
    $phone = filter_var($_POST["phone"], FILTER_SANITIZE_STRING);
    $age = filter_var($_POST["age"], FILTER_VALIDATE_INT);
    $education = filter_var($_POST["education"], FILTER_SANITIZE_STRING);
    $address = filter_var($_POST["address"], FILTER_SANITIZE_STRING);
    $course = filter_var($_POST["course"], FILTER_SANITIZE_STRING);
    $message = filter_var($_POST["message"], FILTER_SANITIZE_STRING);

    if (empty($name) || empty($email) || empty($phone) || empty($age) || empty($education) || empty($address) || empty($course) || empty($message)) {
        echo "Please fill out all required fields.";
        exit();
    }

    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);

    try {
        // SMTP server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF; // Disable debugging (or use SMTP::DEBUG_SERVER for debugging)
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // Set your SMTP server
        $mail->Port = 587; // Use TLS (587) or SSL (465)
        $mail->SMTPSecure = 'tls';
        $mail->SMTPAuth = true;
        $mail->Username = 'atefabdo26399@gmail.com'; // Your SMTP username
        $mail->Password = 'AtefAbdelrahamn99'; // Your SMTP password

        // Recipients
        $to = "atefabdo26399@gmail.com";
        $mail->setFrom($email, $name);
        $mail->addAddress($to);
        $mail->addReplyTo($email, $name);
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        // Attachments (if needed)
        // $mail->addAttachment('/path/to/file.pdf');
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission - $name";
        $mail->Body = "
            <h2>Contact Information:</h2>
            <p>Name: $name</p>
            <p>Email: $email</p>
            <p>Phone Number: $phone</p>
            <p>Age: $age</p>
            <p>Education Level: $education</p>
            <p>Address:<br>$address</p>
            <p>Course Type: $course</p>
            
            <h2>Message:</h2>
            <p>$message</p>
        ";

        $mail->send();
        echo "Email sent successfully!";
    } catch (Exception $e) {
        echo "Email sending failed: " . $mail->ErrorInfo;
    }
} else {
    echo "Invalid request.";
}
?>
