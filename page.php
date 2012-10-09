<!DOCTYPE html>
<html>
    <head>
        <title><?= $page['title'] ?></title>
        <meta name="viewport" content="width=device-width" />
    </head>
    <body>
        <h1><?= $page['title'] ?></h1>
        <div class="now"><?php echo date('Y-m-d H:i:s'); ?></div>
        <?php
        if (isset($page['menu'])) {
            echo '<ol>';
            foreach ($page['menu'] as $chapter) {
                echo '<li>';
                $url = $page_url . '/' . get_shortname($chapter);
                if (isset($chapter['type']))
                    $url .= '.'.$chapter['type'];
                echo '<h2><a href="'.$url.'">'.$chapter['title'].'</a></h2>';
                if (isset($chapter['description']))
                    echo '<p>'.$chapter['description'].'</p>';
                echo '</li>';
            }
            echo '</ol>';
        }
        ?>
    </body>
</html>
