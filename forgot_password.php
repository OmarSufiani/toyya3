<?php
// Enable error reporting for debugging
ini_set('display_errors', 1);
error_reporting(E_ALL);

// DB connection
include 'database/db.php';

// PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// SMTP Configuration (Gmail)
$smtpHost = 'smtp.gmail.com';
$smtpUsername = 'hommiedelaco@gmail.com';
$smtpPassword = 'mkpjatvrhtcwafrr'; // 🔐 Gmail App Password, no spaces!
$smtpPort = 587;

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $email = $conn->real_escape_string($email);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email address.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 0) {
            $error = "Email not found.";
        } else {
            // Generate reset token and expiry
            $token = bin2hex(random_bytes(16));
            $expiry = date('Y-m-d H:i:s', time() + 3600);

            // Save token to database
            $update = $conn->prepare("UPDATE users SET reset_token=?, reset_token_expiry=? WHERE email=?");
            $update->bind_param("sss", $token, $expiry, $email);

            if ($update->execute()) {
                $resetLink = "https://toyya.infinityfreeapp.com/reset_password.php?email=" . urlencode($email) . "&token=$token";

                $subject = "Password Reset Request";
                $message = "To reset your password, click this link:\n\n$resetLink\n\nThis link expires in 1 hour.";

                // Send email using PHPMailer
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host       = $smtpHost;
                    $mail->SMTPAuth   = true;
                    $mail->Username   = $smtpUsername;
                    $mail->Password   = $smtpPassword;
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port       = $smtpPort;

                    $mail->setFrom($smtpUsername, 'FIKRATUL JANNAH ORGANIZATION');
                    $mail->addAddress($email);

                    $mail->isHTML(false);
                    $mail->Subject = $subject;
                    $mail->Body    = $message;

                    $mail->send();
                    $success = "Reset link sent to your email.";
                } catch (Exception $e) {
                    $error = "Mailer Error: " . $mail->ErrorInfo;
                }
            } else {
                $error = "Failed to save reset token to database.";
            }
            $update->close();
        }
        $stmt->close();
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head><title>Forgot Password</title></head>
<body>
    <h2>Forgot Password</h2>
    <?php if ($error) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if ($success) echo "<p style='color:green;'>$success</p>"; ?>

    <form method="post" action="">
        <label>Email: <input type="email" name="email" required></label><br><br>
        <button type="submit">Send Reset Link</button>
    </form>

    <?php if (strpos($_SERVER['HTTP_HOST'], 'infinityfree') !== false): ?>
        
    <?php endif; ?>
</body>
</html>
