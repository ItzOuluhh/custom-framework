<?php

/**
 * Place view in template
 *
 * @param string $content
 */
function renderTemplate($content)
{
    $title = Page::getTitle();

    echo "<!DOCTYPE html>";
    echo "<html lang='nl'>";
    echo "<head>";
    echo "<meta charset='UTF-8'>";
    echo "<meta name='viewport' content='width=device-width, initial-scale=1.0'>";
    echo "<title>{$title}</title>";
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includes_head.html';
    echo "</head>";
    echo "<body>";
    echo $content;
    include_once $_SERVER['DOCUMENT_ROOT'] . '/includes/includes_footer.html';
    echo "</body>";
    echo "</html>";
}
