<?php
// IMPORTANT: valid pages (we will need to change this)
$validPages = ['home', 'about', 'contact'];

$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// cleaning the url
$path = str_replace($scriptName, '', $requestUri);
$path = trim($path, '/');

$pathParts = explode('/', $path);

// first part of the path is assumed to be the page request
$pageRequested = $pathParts[0] ?? null;

if (!in_array($pageRequested, $validPages)) {
    http_response_code(404);
    echo "<h1>404 Page Not Found</h1>";
    echo "<p>The page you requested does not exist.</p>";
    exit;
}

?>
