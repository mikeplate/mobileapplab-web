<?php
function get_html_for_text($text) {
    $text = htmlentities($text);
    $text = str_replace("\n", '<br/>', $text);
    $text = preg_replace('/http:[a-zA-Z0-9\/.-]+/', '<a href="$0" target="_blank">$0</a>', $text);
    return $text;
}

function output_slide($item) {
    echo '<section class="slide">';
    echo '<h1>' . get_html_for_text($item['title']) . '</h1>';
    if (isset($item['menu']))
        output_bullets($item);
    echo '</section>';
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
                echo '<pre>' . $bullet['code'] . '</pre>';
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
        echo '<section class="slide">';
        echo '<h1>' . $page_heading . '</h1>';
        echo '</section>';
        foreach ($page['menu'] as $slide) {
            output_slide($slide);
        }
        ?>
    </body>
</html>
