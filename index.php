<?php
ini_set('display_errors', '1');

// Read full site from disk
$site = yaml_parse_file('data/site.yaml');

// Return object, possibly reading external file
function get_object($item) {
    if (isset($item['ref'])) {
        return yaml_parse_file($item['ref']);
    }
    else {
        return $item;
    }
}

// Return the short name suitable for urls for the specified site object
function get_shortname($item) {
    if (isset($item['shortname'])) {
        $shortname = $item['shortname'];
    }
    else {
        $shortname = strtolower($item['title']);
        $shortname = str_replace(' ', '-', $shortname);
    }
    return $shortname;
}

// Go through all site objects and build a map of urls and objects
function build_url_map($parent, $url, &$map) {
    if (isset($parent['menu']) && is_array($parent['menu'])) {
        foreach ($parent['menu'] as $item) {
            $item_url = $url . '/' . get_shortname($item);
            $map[$item_url] = $item;
            build_url_map($item, $item_url, $map);
        }
    }
}

// Prepare the map of urls and site objects
$url_map = Array();
build_url_map($site, '', $url_map);

// Fetch current page url without optional trailing slash
$page_url = $_SERVER['REQUEST_URI'];
if (substr($page_url, strlen($page_url)-1, 1)=='/')
    $page_url = substr($page_url, 0, strlen($page_url)-1);

// Check for type specification as suffix or url
$type = 'page';
if (preg_match('/\.[a-z]+$/', $page_url)) {
    $find = strrpos($page_url, '.');
    $type = substr($page_url, $find+1, strlen($page_url)-$find-1);
    $page_url = substr($page_url, 0, $find);
}

// Find matching object in site for this url
if (isset($url_map[$page_url])) {
    $page = $url_map[$page_url];
}
else {
    $page = $site;
    $page_url = '';
}

require_once($type . '.php');
?>
