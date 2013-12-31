<?php
$parts = split('/', $page_url);
$path = '/demo/' . str_replace('.', '-', $parts[2]) . '/' . str_replace('.', '-', $parts[count($parts)-1]);
$fullpath = $_SERVER['DOCUMENT_ROOT'] . $path;

$html = file_get_contents($fullpath . '.html');
$body_end_pos = strpos($html, '</body>');
if ($body_end_pos!==false)
    $html = substr($html, 0, $body_end_pos);

echo $html;

if (isset($_SERVER['GOOGLE_ANALYTICS'])) {
?>
<script type="text/javascript">
    var _gaq = _gaq || [];
    _gaq.push(['_setAccount', '<?php echo $_SERVER['GOOGLE_ANALYTICS'] ?>']);
    _gaq.push(['_trackPageview']);

    (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
    })();
</script>
<?php
}
?>
    </body>
</html>

