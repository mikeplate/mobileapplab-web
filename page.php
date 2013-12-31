<!DOCTYPE html>
<?php
function output_menu($start, $start_url, $expand, $level) {
    if (isset($start['menu'])) {
        echo '<ul';
        if ($expand) {
            echo ' class="expand' . $level . '"';
        }
        echo '>';
        $number = 1;
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
            else if (!$has_children || $expand)
                $url = null;

            // Alternative types with extra link. Hardcoded to specific type(s) for now.
            if ($type=='deck') {
                $alttype = 'print';
                if (isset($chapter['altname']))
                    $altname = $chapter['altname'];
                else
                    $altname = $alttype;
                echo '<a href="' . $base_url . '.' . $alttype . '" class="alttype ' . $alttype . '">' . $altname . '</a>';
            }
            else if ($type=='app') {
                $alttype = 'source';
                if (isset($chapter['altname']))
                    $altname = $chapter['altname'];
                else
                    $altname = $alttype;
                echo '<a href="' . $base_url . '.' . $alttype . '" class="alttype ' . $alttype . '">' . $altname . '</a>';
            }

            if ($url!=null)
                echo '<a href="'.$url.'">';

            // Output the main text of this item
            $title = $chapter['title'];
            if ($level>1) {
                echo get_html_for_text($title);
            }
            else {
                echo '<h2>'. $title .'</h2>';
            }

            if (isset($chapter['description']))
                echo '<p>' . get_html_for_text($chapter['description']) . '</p>';
            if ($url!=null)
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
        <?php if (isset($_SERVER['GOOGLE_ANALYTICS'])) { ?>
        <script type="text/javascript">
            var _gaq = _gaq || [];
            _gaq.push(['_setAccount', '<?php echo $_SERVER['GOOGLE_ANALYTICS'] ?>']);
            _gaq.push(['_trackPageview']);

            (function() {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
            })();
        </script>
        <?php } ?>
    </body>
</html>
