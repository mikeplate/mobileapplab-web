<?php
# Extract important part from static html file and build a page to return.
# Assumes that the html file only contains one style-tag and one script-tag
# to be included in the response.

function next_pos($src, $start, $find_char) {
    $quote = false;
    while ($start < strlen($src)) {
        if ($quote) {
            if ($src[$start]=='"')
                $quote = false;
        }
        else if ($src[$start]==$find_char) {
            return $start;
        }
        else if ($src[$start]=='"') {
            $quote = true;
        }
        $start++;
    }
    return false;
}

# Extract a single tag using simple string lookup
function extract_tag($html, $tagname, $includingTag = false) {
    $start = strpos($html, '<'.$tagname);
    if ($start===false)
        return null;
    $start_end = next_pos($html, $start, '>');
    if ($start_end===false)
        return null;

    $end = strpos($html, '</'.$tagname.'>');
    if ($end===false)
        return null;

    if ($start>=0 && $end>=0 && $end>$start) {
        if ($includingTag)
            return trim(substr($html, $start, $end-$start+strlen($tagname)+3))."\r\n";
        else
            return trim(substr($html, $start_end+1, $end-$start_end-1))."\r\n";
    }
    else {
        return null;
    }
}

function extract_tag_attributes($html, $tagname) {
    $start = strpos($html, '<'.$tagname);
    if ($start===false)
        return null;
    $start_end = next_pos($html, $start, '>');
    if ($start_end===false)
        return null;

    return substr($html, $start+strlen($tagname)+1, $start_end-($start+strlen($tagname)+1));
}

$parts = split('/', $page_url);
$path = '/demo/' . str_replace('.', '-', $parts[2]) . '/' . str_replace('.', '-', $parts[count($parts)-1]);
$fullpath = $_SERVER['DOCUMENT_ROOT'] . $path;

if (file_exists($fullpath . '.html')) {
    $path .= '.html';
    $html = file_get_contents($fullpath . '.html');
    $title = extract_tag($html, 'title');
    if (!$title)
        $title = $parts[count($parts)-1];
    $html_attr = extract_tag_attributes($html, 'html');
?>
<!DOCTYPE html>
<html<?php echo $html_attr;?>>
    <head>
        <title><?= $title ?></title>
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" type="text/css" href="/site.css" />
        <?php
        $head = extract_tag($html, 'head');
        if ($head) {
            echo extract_tag($head, 'style', true);
            echo extract_tag($head, 'script', true);
        }
        ?>
    </head>
    <body<?=extract_tag_attributes($html, 'body')?>>
        <h1>Demo <?= $title ?></h1>
        <?php
        $body = extract_tag($html, 'body');
        if (strlen($body)==0)
            $body = $html;
        echo $body;
}
else if (file_exists($fullpath . '.php')) {
    $path .= '.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $page['title'] ?></title>
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" type="text/css" href="/site.css" />
    </head>
    <body>
        <h1>Demo <?= $page['title'] ?></h1>
        <?php
        require_once($fullpath . '.php');
}
?>
        <footer>
            <ul>
                <li class="app">
                    <a target="_blank" class="alttype source" href="https://github.com/mikeplate/mobileapplab-web/blob/master<?= $path ?>">source</a>
                </li>
                <li style="clear: right;"></li>
            </ul>
        </footer>
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

