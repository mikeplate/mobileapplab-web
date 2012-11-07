<?php
$parts = split('/', $page_url);
$path = '/demo/' . str_replace('.', '-', $parts[1]) . '/' . str_replace('.', '-', $parts[count($parts)-1]);
$fullpath = $_SERVER['DOCUMENT_ROOT'] . $path;
if (file_exists($fullpath . '.html'))
    $path .= '.html';
else if (file_exists($fullpath . '.php'))
    $path .= '.php';

$path = 'https://github.com/mikeplate/mobileapplab-web/blob/master' . $path;
header('Location: ' . $path);
?>

