<?php
$result = Array();
$citypop = 2500000;
if (isset($_GET['citypop']) && is_numeric($_GET['citypop'])) {
    $citypop = intval($_GET['citypop']);
}

$filePath = $_SERVER['DOCUMENT_ROOT'] . '/.temp/cities1000.txt';
$file = fopen($filePath, 'r');
while ($line = fgets($file)) {
    $data = split("\t", $line);   
    $pop = floatval($data[14]);

    if ($pop >= $citypop) {
        array_push($result, Array(
            'name' => $data[1], 
            'country' => $data[8], 
            'latitude' => $data[4],
            'longitude' => $data[5],
            'population' => $pop
        ));
    }
}
fclose($file);

function compareCities($a, $b) {
    if ($a['name']==$b['name'])
        return 0;
    else
        return $a['name'] < $b['name'] ? -1:1;
}
usort($result, 'compareCities');

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);
?>
