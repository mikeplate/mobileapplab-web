<!DOCTYPE html>
<html>
    <head>
        <title><?= $page_heading ?></title>
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" type="text/css" href="/site.css" />
    </head>
    <body>
        <h1><?= $page_heading ?></h1>
        <?php
        if (isset($page['menu'])) {
            echo '<ul>';
            foreach ($page['menu'] as $chapter) {
                $url = $page_url . '/' . get_shortname($chapter);
                $base_url = $url;
                $has_children = isset($chapter['menu']) || isset($chapter['ref']) || isset($chapter['type']);
                $type = 'page';

                if (isset($chapter['type'])) {
                    $type = $chapter['type'];
                    $url .= '.' . $type;
                    echo '<li class="' . $type . '">';
                }
                else if ($has_children) {
                    echo '<li class="menu">';
                }
                else {
                    echo '<li>';
                }

                // Alternative types with extra link. Hardcoded to specific type(s) for now.
                if ($type=='deck') {
                    $alttype = 'print';
                    if (isset($chapter['altname']))
                        $altname = $chapter['altname'];
                    else
                        $altname = $alttype;
                    echo '<a href="' . $base_url . '.' . $alttype . '" class="alttype ' . $alttype . '">' . $altname . '</a>';
                }

                if ($has_children)
                    echo '<a href="'.$url.'">';
                echo '<h2>'.$chapter['title'].'</h2>';
                if (isset($chapter['description']))
                    echo '<p>' . get_html_for_text($chapter['description']) . '</p>';
                if ($has_children)
                    echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        }
        ?>
    </body>
</html>
