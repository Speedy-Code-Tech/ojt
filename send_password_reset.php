<?php
// Include PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

ini_set('display_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php'; // Path to your autoload.php (from Composer)
require_once 'backend/db_connect.php'; // Assuming this file contains your MySQLi connection


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"];

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email address.");
    }

    // Check if email exists in the database (MySQLi version)
    $sql = "SELECT * FROM user WHERE email = ?";
    $stmt = $conn->prepare($sql); // $conn is your MySQLi connection from db_connect.php
    $stmt->bind_param("s", $email); // "s" indicates a string parameter
    $stmt->execute();
    $result = $stmt->get_result(); // Get the result set
    $user = $result->fetch_assoc(); // Fetch the user data as an associative array

    if (!$user) {
        die("Email not found in the database.");
    }

    // Generate a new password
    $new_password = substr(str_shuffle(str_repeat("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ", 5)), 0, 10);

    // Update user's password in the database (MySQLi version)

    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT); //Hash the password before storing
    $sql = "UPDATE user SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $email);
    $stmt->execute();


    // Send password reset email using PHPMailer (remains largely the same)
    $mail = new PHPMailer(true);
    try {
        // ... (PHPMailer SMTP settings remain unchanged) ...
        $mail->SMTPDebug = 0;                      // Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'live.smtp.mailtrap.io';                    // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
        $mail->Username   = 'smtp@mailtrap.io';                     // SMTP username
        $mail->Password   = '7aab00f07002b35a2f8e8020cce1322e';                               // SMTP password
        $mail->SMTPSecure = 'tls';         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        $mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        $mail->setFrom('hagupitsalenjohnjester@gmail.com', 'OJT System');
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Password Reset';
        $mail->Body = "Your new password is: $new_password. Please change it after logging in.";
        $mail->send();
        echo "Password reset email sent successfully!";
    } catch (Exception $e) {
        echo "Error sending email: " . $mail->ErrorInfo;
    }
}
?>