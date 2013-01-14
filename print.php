<?php
function output_slide($item, $index) {
    echo '<div class="slide">';
    echo '<h1>' . get_html_for_text($item['title']);
    if (strpos($_SERVER['REQUEST_URI'], 'nonum')===false)
        echo ' <abbr>' . $index . '</abbr>';
    echo '</h1>';
    if (isset($item['menu']))
        output_bullets($item);
    echo '</div>';
}

function output_bullets($item) {
    echo '<ul>';
    foreach ($item['menu'] as $bullet) {
        echo '<li>';
        if (is_string($bullet))
            echo get_html_for_text($bullet);
        else {
            echo get_html_for_text($bullet['title']);
            if (isset($bullet['language']))
                echo '<pre>' . htmlentities($bullet['code']) . '</pre>';
            else if (isset($bullet['description']))
                echo '<ul><li>' . get_html_for_text($bullet['description']) . '</li></ul>';
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
        <title><?= $page_heading ?></title>
        <link rel="stylesheet" href="/print.css" />
    </head>
    <body>
        <?php
        echo '<div class="slide">';
        echo '<h1>' . $page_heading;
        if (strpos($_SERVER['REQUEST_URI'], 'nonum')===false)
            echo ' <abbr>1</abbr>';
        echo '</h1>';
        echo '</div>';
        $index = 2;
        foreach ($page['menu'] as $slide) {
            output_slide($slide, $index);
            $index += 1;
        }
        ?>
    </body>
</html>
