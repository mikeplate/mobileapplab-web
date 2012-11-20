<?php

// Make sure we have a cookie to detect that multiple requests originates from the same user
if (isset($_COOKIE['swarm'])) {
    $user_id = $_COOKIE['swarm'];
}
else {
    $user_id = uniqid();
    setcookie('swarm', $user_id);
}

$data_file_path = $_SERVER['DOCUMENT_ROOT'] . '/.temp/swarm.json';
if (file_exists($data_file_path) && !isset($_GET['reset'])) {
    $jsondata = file_get_contents($data_file_path);
    $data = json_decode($jsondata, true);
}
else {
    $data = Array();
}

$current = null;
for ($i = 0; $i < count($data); $i++) {
    if ($data[$i]['id']==$user_id) {
        $current = &$data[$i];
    }
    else if ((time()-strtotime($data[$i]['updated'])) > 864000) {
        array_splice($data, $i, 1);
        $i--;
    }
}
if ($current==null) {
    array_push($data, Array(
        'id' => $user_id,
        'latitude' => 0,
        'longitude' => 0
    ));
    $current = &$data[count($data)-1];
}
$current['ip'] = $_SERVER['REMOTE_ADDR'];
$current['useragent'] = $_SERVER['HTTP_USER_AGENT'];
$current['updated'] = date('Y-m-d H:i:s');
if (isset($_GET['latitude']))
    $current['latitude'] = (double)$_GET['latitude'];
if (isset($_GET['longitude']))
    $current['longitude'] = (double)$_GET['longitude'];

$jsondata = json_encode($data);
file_put_contents($data_file_path, $jsondata);

$current['self'] = true;
$jsondata = json_encode($data);
header('Content-type: application/json');
echo $jsondata;
?>
