<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mailer
{
    public static function sendAgentTemporaryPassword($agentEmail, $agentName, $agentPassword)
    {
        require_once __DIR__ . '/../vendor/autoload.php';

        if (!class_exists(PHPMailer::class)) {
            error_log('PHPMailer is not installed.');
            return false;
        }

        $config = require __DIR__ . '/../configs/mail.php';

        if (empty($config['username']) || empty($config['password']) || empty($config['from_email'])) {
            error_log('Mail config is incomplete.');
            return false;
        }

        try {

            $mail = new PHPMailer(true);

            // =========================
            // SMTP CONFIG (FIXED)
            // =========================
            $mail->isSMTP();
            $mail->Host = $config['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $config['username'];
            $mail->Password = $config['password'];

            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // =========================
            // LARAGON SSL FIX (IMPORTANT)
            // =========================
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];

            // =========================
            // EMAIL SETUP
            // =========================
            $mail->setFrom($config['from_email'], $config['from_name']);
            $mail->addAddress($agentEmail, $agentName);
            $mail->isHTML(true);

            $mail->Subject = 'Your Habitrack Agent Account';

            $mail->Body = '
                <p>Hello ' . htmlspecialchars($agentName, ENT_QUOTES, 'UTF-8') . ',</p>
                <p>Your Habitrack agent account has been created.</p>
                <p>
                    <strong>Email:</strong> ' . htmlspecialchars($agentEmail, ENT_QUOTES, 'UTF-8') . '<br>
                    <strong>Temporary Password:</strong> ' . htmlspecialchars($agentPassword, ENT_QUOTES, 'UTF-8') . '
                </p>
                <p>Please change your password after logging in.</p>
            ';

            $mail->AltBody = "Hello {$agentName},\n\nYour Habitrack agent account has been created.\n\nEmail: {$agentEmail}\nTemporary Password: {$agentPassword}\n\nPlease change your password after logging in.";

            $mail->send();
            return true;

        } catch (Exception $e) {

            echo "Mailer Error: " . $mail->ErrorInfo;
            echo "<br>Exception: " . $e->getMessage();

            return false;
        }
    }
}