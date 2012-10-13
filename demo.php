<?php
# Extract important part from static html file and build a page to return.
# Assumes that the html file only contains one style-tag and one script-tag
# to be included in the response.

# Extract a single tag using simple string lookup
function extract_tag($html, $tagname, $includingTag = false) {
    $start = strpos($html, '<'.$tagname.'>');
    $end = strpos($html, '</'.$tagname.'>');
    if ($start>=0 && $end>=0 && $end>$start) {
        if ($includingTag)
            return trim(substr($html, $start, $end-$start+strlen($tagname)+3))."\r\n";
        else
            return trim(substr($html, $start+strlen($tagname)+2, $end-$start-strlen($tagname)-2))."\r\n";
    }
    else {
        return '';
    }
}

$parts = split('/', $page_url);
$path = '/demo/' . str_replace('.', '-', $parts[1]) . '/' . str_replace('.', '-', $parts[count($parts)-1]) . '.html';
$path = $_SERVER['DOCUMENT_ROOT'] . $path;
$html = file_get_contents($path);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?= $page['title'] ?></title>
        <meta name="viewport" content="width=device-width" />
        <link rel="stylesheet" type="text/css" href="/site.css" />
        <?php echo extract_tag($html, 'style', true); ?>
        <?php echo extract_tag($html, 'script', true); ?>
    </head>
    <body>
        <h1>Demo <?= $page['title'] ?></h1>
        <?php echo extract_tag($html, 'body'); ?>
    </body>
</html>
