<?php

namespace App\Models;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class Mail {
    private $mail;

    public function __construct() {
        $env = parse_ini_file(__DIR__ . '/../../.env');
        
        $this->mail = new PHPMailer(true);

        // Server settings
        $this->mail->isSMTP();
        $this->mail->Host       = $env['SMTP_HOST'];
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = $env['SMTP_USER'];
        $this->mail->Password   = $env['SMTP_PASS'];
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mail->Port       = $env['SMTP_PORT'];
        $this->mail->CharSet    = 'UTF-8';

        // Recipients
        $this->mail->setFrom($env['SMTP_FROM'], $env['SMTP_FROM_NAME']);
    }

    public function send($to, $subject, $body) {
        try {
            $this->mail->addAddress($to);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body    = $body;

            return $this->mail->send();
        } catch (Exception $e) {
            error_log("Mail Gönderim Hatası: " . $this->mail->ErrorInfo);
            return false;
        }
    }
}
