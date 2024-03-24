<?php
// IMPORTANT: valid pages (we will need to change this)
$validPages = ['home', 'about', 'contact'];

$requestUri = $_SERVER['REQUEST_URI'];
$scriptName = $_SERVER['SCRIPT_NAME'];

// cleaning the url
$path = str_replace($scriptName, '', $requestUri);
$path = trim($path, '/');

?>
