<?php
ini_set('display_errors', '1');

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

// Split url into parts
$path_parts = split('/', substr($page_url, 1));

// Read full site from disk
$base_url = '';
if (count($path_parts)>0 && file_exists('data/'.$path_parts[0].'.yaml')) {
    $site = yaml_parse_file('data/'.$path_parts[0].'.yaml');
    $base_url = '/'.$path_parts[0];
}
else
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
build_url_map($site, $base_url, $url_map);

// Find matching object in site for this url
if (isset($url_map[$page_url])) {
    $page = $url_map[$page_url];
}
else {
    $page = $site;
    $page_url = $base_url;
}

# Set variable for heading text (usually same as title)
if (isset($page['heading']))
    $page_heading = $page['heading'];
else
    $page_heading = $page['title'];

require_once($type . '.php');
?>

