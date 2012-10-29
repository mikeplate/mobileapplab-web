<!DOCTYPE html>
<?php
function output_menu($start, $start_url, $expand, $level) {
    if (isset($start['menu'])) {
        echo '<ul>';
        foreach ($start['menu'] as $chapter) {
            $url = $start_url . '/' . get_shortname($chapter);
            $base_url = $url;
            $has_children = isset($chapter['menu']) || isset($chapter['ref']) || isset($chapter['type']) || isset($chapter['link']);
            $type = 'page';

            if (isset($chapter['type'])) {
                $type = $chapter['type'];
                $url .= '.' . $type;
                echo '<li class="' . $type . '">';
            }
            else if ($has_children && !$expand) {
                echo '<li class="menu">';
            }
            else if ($level>0) {
                echo '<li class="submenu">';
            }
            else {
                echo '<li>';
            }

            if (isset($chapter['link']))
                $url = $chapter['link'];

            // Alternative types with extra link. Hardcoded to specific type(s) for now.
            if ($type=='deck') {
                $alttype = 'print';
                if (isset($chapter['altname']))
                    $altname = $chapter['altname'];
                else
                    $altname = $alttype;
                echo '<a href="' . $base_url . '.' . $alttype . '" class="alttype ' . $alttype . '">' . $altname . '</a>';
            }

            if ($has_children && !$expand)
                echo '<a href="'.$url.'">';
            echo '<h2>'.$chapter['title'].'</h2>';
            if (isset($chapter['description']))
                echo '<p>' . get_html_for_text($chapter['description']) . '</p>';
            if ($has_children && !$expand)
                echo '</a>';

            if ($expand)
                output_menu($chapter, $start_url, $expand, $level+1);

            echo '</li>';
        }
        echo '</ul>';
    }
}
?>
<html>
    <head>
        <title><?= $page_heading ?></title>
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" type="text/css" href="/site.css" />
    </head>
    <body>
        <h1><?= $page_heading ?></h1>
        <?php output_menu($page, $page_url, isset($page['expand']), 0); ?>
    </body>
</html>
