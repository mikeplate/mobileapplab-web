<!DOCTYPE html>
<?php
ini_set('display_errors', '1');

$site = yaml_parse_file('data/site.yaml');

function get_object($item) {
    if (isset($item['ref'])) {
        return yaml_parse_file($item['ref']);
    }
    else {
        return $item;
    }
}
?>
<html>
    <body>
        <h1><?php echo $site['title'] ?></h1>
        <div class="now"><?php echo date('Y-m-d H:i:s'); ?></div>
        <?php
        # var_dump($site);

        foreach ($site['menu'] as $chapter) {
            echo '<h2>'.$chapter['title'].'</h2>';
            if (isset($chapter['description']))
                echo '<p>'.$chapter['description'].'</p>';

            if (isset($chapter['menu'])) { 
                foreach ($chapter['menu'] as $item) {
                    echo '<h3>'.$item['title'].'</h3>';
                    if (isset($item['description']))
                        echo '<p>'.$item['description'].'</p>';

                    if (isset($item['menu'])) {
                        foreach ($item['menu'] as $subitem) {
                            echo '<h4>'.$subitem['title'].'</h4>';
                            if (isset($subitem['description']))
                                echo '<p>'.$subitem['description'].'</p>';
                        }
                    }
                }
            }
        }
        ?>
    </body>
</html>
