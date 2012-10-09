<?php
function output_bullets($item) {
    echo '<ul>';
    foreach ($item['menu'] as $bullet) {
        echo '<li>';
        if (is_string($bullet))
            echo $bullet;
        else {
            echo $bullet['title'];
            if (isset($bullet['description']))
                echo '<ul><li>' . $bullet['description'] . '</li></ul>';
            else if (isset($bullet['menu']))
                output_bullets($bullet);
        }
        echo '</li>';
    }
    echo '</ul>';
}
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $page['title'] ?></title>
    </head>
    <body>
        <h1><?= $page['title'] ?></h1>
        <?php
        output_bullets($page);
        ?>
    </body>
</html>
