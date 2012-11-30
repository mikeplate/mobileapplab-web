<?php
$api = $_GET['api'];
$method = $_GET['method'];
$query = $_GET['query'];
if ($api=='resrobot')
    $key = $_SERVER['TRAFIKLAB_RESROBOT_API_KEY'];
else
    $key = $_SERVER['TRAFIKLAB_RESROBOTSTOPS_API_KEY'];
$url = 'https://api.trafiklab.se/samtrafiken/'.$api.'/'.$method.'.json?'.$query.'&key='.$key;

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
 
$data = curl_exec($ch);
$status = curl_getinfo($ch);
curl_close($ch);

echo $data
?>

