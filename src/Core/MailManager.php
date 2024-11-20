<?php

namespace Cloudstorage\Core;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailManager
{
    private $config;
    private $mailer;

    public function __construct()
    {
        $this->config = require __DIR__ . '/../../config/mail.config.php';
        $this->mailer = new PHPMailer(true);
        $this->setupMailer();
    }

    private function setupMailer()
    {
        $this->mailer->isSMTP();
        $this->mailer->Host = $this->config['host'];
        $this->mailer->SMTPAuth = true;
        $this->mailer->Username = $this->config['username'];
        $this->mailer->Password = $this->config['password'];
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $this->mailer->Port = $this->config['port'];

        $this->mailer->setFrom(
            $this->config['from']['address'],
            $this->config['from']['name']
        );

        if (isset($this->config['reply_to'])) {
            $this->mailer->addReplyTo(
                $this->config['reply_to']['address'],
                $this->config['reply_to']['name']
            );
        }

        $this->mailer->isHTML(true);
    }

    public function send($to, $subject, $body, $attachments = [])
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body = $body;

            foreach ($attachments as $filePath) {
                if (file_exists($filePath)) {
                    $this->mailer->addAttachment($filePath);
                }
            }
            $this->mailer->send();
            return true;
        } catch (Exception $e) {
            throw new \Exception("E-mail versturen mislukt: " . $this->mailer->ErrorInfo);
        }
    }
}
