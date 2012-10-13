<!DOCTYPE html>
<html>
    <head>
        <title><?= $page['title'] ?></title>
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" type="text/css" href="/site.css" />
    </head>
    <body>
        <h1><?= $page['title'] ?></h1>
        <div class="now"><?php echo date('Y-m-d H:i:s'); ?></div>
        <?php
        if (isset($page['menu'])) {
            echo '<ul>';
            foreach ($page['menu'] as $chapter) {
                echo '<li>';
                $url = $page_url . '/' . get_shortname($chapter);
                if (isset($chapter['type']))
                    $url .= '.'.$chapter['type'];
                echo '<a href="'.$url.'"><h2>'.$chapter['title'].'</h2>';
                if (isset($chapter['description']))
                    echo '<p>'.$chapter['description'].'</p>';
                echo '</a></li>';
            }
            echo '</ul>';
        }
        ?>
    </body>
</html>
