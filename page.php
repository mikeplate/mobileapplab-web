<!DOCTYPE html>
<html>
    <head>
        <title><?= $page_heading ?></title>
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" type="text/css" href="/site.css" />
    </head>
    <body>
        <h1><?= $page_heading ?></h1>
        <div class="now"><?php echo date('Y-m-d H:i:s'); ?></div>
        <?php
        if (isset($page['menu'])) {
            echo '<ul>';
            foreach ($page['menu'] as $chapter) {
                echo '<li>';
                $url = $page_url . '/' . get_shortname($chapter);
                if (isset($chapter['type']))
                    $url .= '.'.$chapter['type'];
                $has_children = isset($chapter['menu']) || isset($chapter['ref']);
                if ($has_children)
                    echo '<a href="'.$url.'">';
                echo '<h2>'.$chapter['title'].'</h2>';
                if (isset($chapter['description']))
                    echo '<p>'.$chapter['description'].'</p>';
                if ($has_children)
                    echo '</a>';
                echo '</li>';
            }
            echo '</ul>';
        }
        ?>
    </body>
</html>
