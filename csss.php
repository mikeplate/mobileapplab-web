<?php
function output_slide($item) {
    echo '<section class="slide">';
    echo '<h2>' . get_html_for_text($item['title']) . '</h2>';
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
                echo '<script type="syntaxhighlighter" class="brush: ' . $bullet['language'] . '">' . htmlentities($bullet['code']) . '</script>';
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
        <link rel="stylesheet" href="/lib/csss/slideshow.css">
        <link rel="stylesheet" href="/lib/csss/theme.css">
        <link rel="stylesheet" href="/lib/csss/talk.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script src="/lib/csss/prefixfree.min.js"></script>
        <style>
        div.syntaxhighlighter {
            font-size: 12pt !important;
        }
        </style>
    </head>
    <body data-duration="45">
        <header class="slide" id="intro">
            <h1><?= $page_heading ?></h1>
        </header>
        <?php
        foreach ($page['menu'] as $slide) {
            output_slide($slide);
        }
        ?>
        <!-- Extensions -->
        <script src="/scripts/deck.syntaxhighlighter.js"></script>

        <!-- Initialize -->
        <script src="/lib/csss/slideshow.js"></script>
        <script>
        var slideshow = new SlideShow();
        </script>
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
