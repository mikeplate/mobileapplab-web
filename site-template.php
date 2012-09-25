<!DOCTYPE html>
<?php
ini_set('display_errors', '1');
?>
<html>
    <body>
        <h1>This is my handler</h1>
        <?php

        $path = $_SERVER['REQUEST_URI'];
        if (substr($path, strlen($path)-1, 1)=='/')
            $path = substr($path, 0, strlen($path)-1);
        $path = $_SERVER['DOCUMENT_ROOT'].$path;

        if (is_file($path.'.php')) {
            require_once($path.'.php');
        }
        else if (is_file($path.'.html')) {
            require_once($path.'.html');
        }
        else {
            echo '<h2>File Not Found</h2>';
        }
        ?>
    </body>
</html>

