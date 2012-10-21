<ul>
    <li>
        <h2>Your User Agent is:</h2>
        <p><?php echo $_SERVER['HTTP_USER_AGENT'] ?></p>
    </li>
    <li>
        <h2>Top list of user agents</h2>
        <p>
        <table>
<?php
$filename = dirname(__FILE__) . '/useragents.txt';
if (!isset($_COOKIE['stored_user_agent'])) {
    $file = fopen($filename, 'a');
    fwrite($file, $_SERVER['HTTP_USER_AGENT'] . "\r\n");
    fclose($file);
    setcookie('stored_user_agent', '1');
}

$all = array();
$file = fopen($filename, 'r');
if ($file) {
    while (!feof($file)) {
        $line = fgets($file);
        if (strlen($line) > 0) {
            if (isset($all[$line])) {
                $all[$line]++;
            }
            else {
                $all[$line] = 1;
            }
        }
    }
    fclose($file);
}
arsort($all);
foreach ($all as $agent => $count) {
    echo "<tr><td>$count</td><td>$agent</td></tr>";
}
?>
        </table>
        </p>
    </li>
</ul>

