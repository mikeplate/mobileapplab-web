<?php

// Make sure we have a cookie to detect that multiple requests originates from the same user
if (isset($_COOKIE['swarm'])) {
    $user_id = $_COOKIE['swarm'];
}
else {
    $user_id = uniqid();
    setcookie('swarm', $user_id);
}

if (file_exists('/.temp/swarm.json')) {
    $jsondata = file_get_contents('/.temp/swarm.json');
    $data = json_decode($jsondata);
}
else {
    $data = [];
}

foreach ($obj in $data) {
}

$jsondata = json_encode($data);
file_put_contents('/.temp/swarm.json');
echo $jsondata;
?>
