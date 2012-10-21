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
                echo '<script type="syntaxhighlighter" class="brush: ' . $bullet['language'] . '">' . $bullet['code'] . '</script>';
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
        <link rel="stylesheet" href="/lib/deck/core/deck.core.css">
        <link rel="stylesheet" href="/lib/deck/extensions/goto/deck.goto.css">
        <link rel="stylesheet" href="/lib/deck/extensions/menu/deck.menu.css">
        <link rel="stylesheet" href="/lib/deck/extensions/navigation/deck.navigation.css">
        <link rel="stylesheet" href="/lib/deck/extensions/status/deck.status.css">
        <link rel="stylesheet" href="/lib/deck/extensions/hash/deck.hash.css">
        <link rel="stylesheet" href="/lib/deck/extensions/scale/deck.scale.css">
        <link rel="stylesheet" href="/lib/deck/themes/style/web-2.0.css">
        <link rel="stylesheet" href="/lib/deck/themes/transition/horizontal-slide.css">
        <script src="/lib/deck/modernizr.custom.js"></script>
        <style>
        div.syntaxhighlighter {
            font-size: 12pt !important;
        }
        </style>
    </head>
    <body class="deck-container">
        <section class="slide" id="title-slide">
            <h1><?= $page_heading ?></h1>
        </section>
        <?php
        foreach ($page['menu'] as $slide) {
            output_slide($slide);
        }
        ?>
        <!-- deck.navigation snippet -->
        <a href="#" class="deck-prev-link" title="Previous">&#8592;</a>
        <a href="#" class="deck-next-link" title="Next">&#8594;</a>

        <!-- deck.status snippet -->
        <p class="deck-status">
            <span class="deck-status-current"></span>
            /
            <span class="deck-status-total"></span>
        </p>

        <!-- deck.goto snippet -->
        <form action="." method="get" class="goto-form">
            <label for="goto-slide">Go to slide:</label>
            <input type="text" name="slidenum" id="goto-slide" list="goto-datalist">
            <datalist id="goto-datalist"></datalist>
            <input type="submit" value="Go">
        </form>

        <!-- deck.hash snippet -->
        <a href="." title="Permalink to this slide" class="deck-permalink">#</a>


        <!-- Grab CDN jQuery, with a protocol relative URL; fall back to local if offline -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
        <script>window.jQuery || document.write('<script src="/lib/deck/jquery-1.7.2.min.js"><\/script>')</script>

        <!-- Deck Core and extensions -->
        <script src="/lib/deck/core/deck.core.js"></script>
        <script src="/lib/deck/extensions/hash/deck.hash.js"></script>
        <script src="/lib/deck/extensions/menu/deck.menu.js"></script>
        <script src="/lib/deck/extensions/goto/deck.goto.js"></script>
        <script src="/lib/deck/extensions/status/deck.status.js"></script>
        <script src="/lib/deck/extensions/navigation/deck.navigation.js"></script>
        <script src="/lib/deck/extensions/scale/deck.scale.js"></script>
        <script src="/scripts/deck.syntaxhighlighter.js"></script>

        <!-- Initialize the deck -->
        <script>
        $(function() {
            $.deck('.slide');
        });
        </script>
    </body>
</html>
