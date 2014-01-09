<?php
// Fetch current page url without optional trailing slash
$page_url = $_SERVER['REQUEST_URI'];
if (substr($page_url, strlen($page_url)-1, 1)=='/')
    $page_url = substr($page_url, 0, strlen($page_url)-1);
if (strpos($page_url, '?')>0)
    $page_url = substr($page_url, 0, strpos($page_url, '?'));

// Check for type specification as suffix or url
$type = 'page';
if (preg_match('/\.[a-z]+$/', $page_url)) {
    $find = strrpos($page_url, '.');
    $type = substr($page_url, $find+1, strlen($page_url)-$find-1);
    $page_url = substr($page_url, 0, $find);
}

// Split url into parts
if ($page_url == '') {
    $path_parts = Array();
}
else {
    $path_parts = split('/', substr($page_url, 1));
}

// Return the short name suitable for urls for the specified site object
function get_shortname($item) {
    if (isset($item['shortname'])) {
        $shortname = $item['shortname'];
    }
    else {
        if (is_string($item))
            $shortname = strtolower($item);
        else
            $shortname = strtolower($item['title']);
        if (strpos($shortname, '+') === 0) {
            $shortname = ltrim(substr($shortname, 1));
        }
        $shortname = str_replace(' ', '-', $shortname);
    }
    return $shortname;
}

function get_html_for_text($text) {
    if (strlen($text)>0 && substr($text, 0, 1)=='\\')
        $text = substr($text, 1);
    else
        $text = htmlentities($text);
    $text = str_replace("\n", '<br/>', $text);
    $text = preg_replace('/https?:[a-zA-Z0-9\#\/._?=&,-[\\]%]+/', '<a href="$0" target="_blank">$0</a>', $text);
    return $text;
}

function get_html_for_table($text) {
    $html = '<table>';
    for ($i = 0; $i < count($text); $i++) {
        $row = $text[$i]['row'];
        $html .= '<tr>';
        for ($j = 0; $j < count($row); $j++) {
            $html .= '<td>' . $row[$j] . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
}

define('SUB_CONTENT_LABEL', 'menu');
define('INCLUDE_FILE_LABEL', 'include');

function build_site(&$obj, &$number, $path) {
    // If the object has an 'include' property, read that file from disk and overwrite the object properties
    if (isset($obj[INCLUDE_FILE_LABEL])) {
        $includePath = $path . '/' . $obj[INCLUDE_FILE_LABEL] . '.yaml';
        if (!file_exists($includePath)) {
            $obj['title'] = "${obj[INCLUDE_FILE_LABEL]} (missing file)";
            return;
        }
        $path = dirname($includePath);
        $objInclude = yaml_parse_file($includePath);
        $obj = array_merge($objInclude, $obj);
        unset($obj[INCLUDE_FILE_LABEL]);
    }

    // Process properties of the item
    $obj['shortname'] = get_shortname($obj);
    if (strpos($obj['title'], '+') === 0) {
        $obj['title'] = $number . '.' . substr($obj['title'], 1);
        $number++;
    }

    if (isset($obj[SUB_CONTENT_LABEL]) && is_array($obj[SUB_CONTENT_LABEL])) {
        $sub_number = 1;
        foreach ($obj[SUB_CONTENT_LABEL] as &$sub_obj) {
            // If single item is a string, we convert it to the minimal object with a title property
            if (is_string($sub_obj)) {
                $sub_obj = Array('title' => $sub_obj);
            }

            $sub_obj['parent'] = $obj;
            build_site($sub_obj, $sub_number, $path);
        }
    }
}

function find_child($parent, $childName) {
    $index = 0;
    $sub = $parent[SUB_CONTENT_LABEL];
    while ($index < count($sub) && $sub[$index]['shortname'] != $childName) {
        $index++;
    }
    return $index < count($sub) ? $sub[$index] : NULL;
}

$site = Array('include' => 'site');
$temp_number = 1;
build_site($site, $temp_number, 'data');

$page = $site;
$part_index = 0;
while ($page != NULL && $part_index < count($path_parts) && isset($page[SUB_CONTENT_LABEL])) {
    $page = find_child($page, $path_parts[$part_index]);
    $part_index++;
}
$page_heading = $page['title'];

require_once($type . '.php');
?>

