<?php

namespace Cloudstorage\Core;

class MailTemplate
{
    public static function render($templateName, $data = [])
    {
        $filePath = __DIR__ . "/../../app/Resources/Emails/{$templateName}.template.php";

        if (file_exists($filePath)) {
            extract($data);
            ob_start();
            include $filePath;
            return ob_get_clean();
        }

        throw new \Exception("E-mail template '{$templateName}' not found.");
    }
}
