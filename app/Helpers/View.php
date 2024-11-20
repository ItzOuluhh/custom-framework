<?php

require_once __DIR__ . '/Page.php';
require_once __DIR__ . '/RenderTemplate.php';

/**
 * Render a view
 *
 * @param string $viewName
 * @param array $data
 */
function view($viewName, $data = [])
{
    extract($data);

    if (strpos($viewName, '@') !== false) {
        [$file, $folder] = explode('@', $viewName);
        $viewPath = "{$folder}/{$file}";
    } else {
        $viewPath = $viewName;
    }

    $filePath = __DIR__ . "/../Resources/Views/{$viewPath}.template.php";

    if (file_exists($filePath)) {
        ob_start();
        require $filePath;
        $viewContent = ob_get_clean();

        renderTemplate($viewContent);
    } else {
        handleViewError($viewName, $viewPath);
    }
}

/**
 * Foutafhandelingsfunctie voor ontbrekende views
 *
 * @param string $viewName
 * @param string $viewPath
 */
function handleViewError($viewName, $viewPath)
{
    header('HTTP/1.0 404 Not Found');
    header('Content-Type: application/json');
    echo json_encode([
        'statusCode' => '404',
        'error' => 'ERR_VIEW_NOT_FOUND',
        'view' => ['name' => $viewName, 'path' => "/{$viewPath}.php"]
    ]);
    exit;
}
