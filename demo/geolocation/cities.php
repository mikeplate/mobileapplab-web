<?php
$result = Array();
$result['closest'] = Array();
$result['city'] = Array();
$result['vicinity'] = Array();

$latpos = floatval($_GET['lat']);
$longpos = floatval($_GET['long']);
$within = 50;
if (isset($_GET['within']) && is_numeric($_GET['within'])) {
    $within = intval($_GET['within']);
}
$citypop = 10000;
if (isset($_GET['citypop']) && is_numeric($_GET['citypop'])) {
    $citypop = intval($_GET['citypop']);
}

function distance($lat1, $lon1, $lat2, $lon2) { 
    $theta = $lon1 - $lon2; 
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta)); 
    $dist = acos($dist); 
    $dist = rad2deg($dist); 
    $miles = $dist * 60 * 1.1515;
    return ($miles * 1.609344); 
}

$filePath = $_SERVER['DOCUMENT_ROOT'] . '/.temp/cities1000.txt';
$file = fopen($filePath, 'r');
$result['totalvicinity'] = 0;
while ($line = fgets($file)) {
    $data = split("\t", $line);   
    $lat = floatval($data[4]);
    $long = floatval($data[5]);
    $dist = distance($lat, $long, $latpos, $longpos);
    $pop = floatval($data[14]);

    if (!isset($result['closest']['distance']) || $dist < $result['closest']['distance']) {
        $result['closest']['name'] = $data[1];
        $result['closest']['distance'] = $dist;
        $result['closest']['pop'] = $pop;
    }

    if ($pop > $citypop && (!isset($result['city']['distance']) || $dist < $result['city']['distance'])) {
        $result['city']['name'] = $data[1];
        $result['city']['distance'] = $dist;
        $result['city']['pop'] = $pop;
    }

    if ($dist < $within) {
        $result['totalvicinity'] += $pop;
        array_push($result['vicinity'], Array(
            'name' => $data[1], 
            'distance' => $dist, 
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
usort($result['vicinity'], 'compareCities');

header('Content-Type: application/json; charset=utf-8');
echo json_encode($result);
?>
