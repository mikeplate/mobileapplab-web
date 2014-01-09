<?php
function output_slide($item) {
    echo '<section>';
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
            else if (isset($bullet['table']))
                echo get_html_for_table($bullet['table']);
            else if (isset($bullet['html']))
                echo $bullet['html'];
            else if (isset($bullet['menu']))
                output_bullets($bullet);
        }
        echo '</li>';
    }
    echo '</ul>';
}
?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title><?= $page_heading ?></title>
		<meta name="description" content="">
		<meta name="author" content="Mikael Plate">
		<meta name="apple-mobile-web-app-capable" content="yes" />
		<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
		<link rel="stylesheet" href="/lib/reveal/css/reveal.min.css">
		<link rel="stylesheet" href="/lib/reveal/css/theme/default.css" id="theme">
		<link rel="stylesheet" href="/lib/reveal/lib/css/zenburn.css">
		<!--[if lt IE 9]>
		<script src="/lib/reveal/lib/js/html5shiv.js"></script>
		<![endif]-->
        <style>
        .reveal table td {
            padding: 2px 10px;
        }
        </style>
	</head>
	<body>
		<div class="reveal">
			<div class="slides">
				<section>
                    <h1><?= $page_heading ?></h1>
				</section>
                <?php
                foreach ($page['menu'] as $slide) {
                    output_slide($slide);
                }
                ?>
			</div>
		</div>
		<script src="/lib/reveal/lib/js/head.min.js"></script>
		<script src="/lib/reveal/js/reveal.min.js"></script>
		<script>
			Reveal.initialize({
				controls: true,
				progress: true,
				history: true,
				center: true,
				theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
				transition: Reveal.getQueryHash().transition || 'default', // default/cube/page/concave/zoom/linear/fade/none
				dependencies: [
					{ src: '/lib/reveal/lib/js/classList.js', condition: function() { return !document.body.classList; } },
					{ src: '/lib/reveal/plugin/highlight/highlight.js', async: true, callback: function() { hljs.initHighlightingOnLoad(); } },
					{ src: '/lib/reveal/plugin/zoom-js/zoom.js', async: true, condition: function() { return !!document.body.classList; } },
					{ src: '/lib/reveal/plugin/notes/notes.js', async: true, condition: function() { return !!document.body.classList; } }
				]
			});
		</script>
	</body>
</html>
