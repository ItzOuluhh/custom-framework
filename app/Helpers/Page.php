<?php

class Page
{
    private static string $title = '';

    /**
     * Set the page title.
     */
    public static function setTitle(string $title): void
    {
        self::$title = $title;
    }

    /**
     * Get the page title.
     */
    public static function getTitle(): string
    {
        return self::$title ?: 'Default Title';
    }

    /**
     * Render a template by name.
     */

    public static function addTemplate(string $templateName)
    {
        $templateDirectory = __DIR__ . '/../../Resources/Templates/';     
    }
}
