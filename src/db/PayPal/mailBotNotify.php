<?php

//require '../../vendor/autoload.php'; original vendor path, however got removed as its not relative to wanted path for paymentUpdate
require __DIR__ . '../../../vendor/autoload.php';


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailSender
{
    private $title;
    private $content;
    private $recipient;
    private $attachement;

    public function __construct($title, $content, $recipient, $attachement)
    {
        $this->title = $title;
        $this->content = $content;
        $this->recipient = $recipient;
        $this->attachement = $attachement;
    }

    public function sendEmail()
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->Username   = 'fliegenderteppichverlag@gmail.com';
            $mail->Password   = getenv('MAIL_PASSWORD') ?: 'REPLACE_ME';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->SMTPAuth   = true;

            $to = $this->recipient;
            $subject = $this->title;
            $message = $this->content;

            $mail->setFrom('fliegenderteppichverlag@gmail.com', 'Fliegender Teppich');
            $mail->addAddress($to, 'Ute Schuler');

            $mail->isHTML(true);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->CharSet = 'UTF-8';

            $attachment = is_string($this->attachement) ? $this->attachement : json_encode($this->attachement);

            if ($attachment != 0) {
                $mail->addStringAttachment($attachment, 'accountInfo.json');
            }
            $mail->send();
            echo json_encode("Email sent successfully to {$this->recipient}!");
        } catch (Exception $e) {
            echo "Failed to send email. Error: {$mail->ErrorInfo}";
        }
    }
}
