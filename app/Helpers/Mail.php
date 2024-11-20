<?php

use Cloudstorage\Core\MailManager;
use Cloudstorage\Core\MailTemplate;

/**
 * Send an email using a predefined template
 *
 * @param string $to - The recipient's email address
 * @param string $name - The recipient's name
 * @param string $subject - The subject of the email
 * @param string $templateName - The name of the template to use
 * @param array $data - The data to pass to the template
 * @return bool
 */
function sendMail($to, $subject, $templateName, $data = [])
{
    $mailManager = new MailManager();

    try {
        $template = MailTemplate::render($templateName, $data);
        $mailManager->send($to, $subject, $template);
        return true;
    } catch (Exception $e) {
        return false;
    }
}
