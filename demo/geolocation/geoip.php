<?php
$filePath = $_SERVER['DOCUMENT_ROOT'] . '/.temp/IpToCountry.csv';

$result = Array();
$result['found'] = false;
header('Content-Type: application/json');

if (isset($_GET['ip'])) 
    $ip = $_GET['ip'];
else
    $ip = $_SERVER['REMOTE_ADDR'];

$ipBytes = split('\.', $ip);
if (count($ipBytes)!=4) {
    $result['error'] = 'Please specify a valid ip (v4) in the query string';
    echo json_encode($result);
    die();
}
for ($i = 0; $i<4; $i++) {
    $ipBytes[$i] = intval($ipBytes[$i]);
    if ($ipBytes[$i]<0 || $ipBytes[$i]>255) {
        $result['error'] = 'Please specify a valid ip (v4) in the query string';
        echo json_encode($result);
        die();
    }
}

$ipValue = $ipBytes[0]*256*256*256 + $ipBytes[1]*256*256 + $ipBytes[2]*256 + $ipBytes[3];
$file = fopen($filePath, 'r');
while (($line = fgetcsv($file))!=null && !$result['found']) {
    if (count($line)>=7 && $line[0][0]!='#') {
        $from = intval($line[0]);
        $to = intval($line[1]);
        if ($ipValue>=$from && $ipValue<=$to) {
            $result['found'] = true;
            $result['code'] = $line[4];
            $result['name'] = $line[6];
        }
    }
}
fclose($file);

$result['ip'] = $ip;
echo json_encode($result);
?>

