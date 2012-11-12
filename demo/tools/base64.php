<ul>
    <li>
<?php
if ($_SERVER['REQUEST_METHOD']=='GET') {
    ?>
    <h2>Specify image file to encode in Base64</h2>
    <p>
        This tool will encode the uploaded image in Base64 and create an img element suitable for pasting
        into your html page. It will also separate the data into lines of 100 characters which will be
        easier to handle for your text editor.
    </p>
    <form method="POST" enctype="multipart/form-data">
        <p>
            <input type="file" name="image" /><br />
            <input type="submit" value="Upload and Encode" />
        </p>
    </form>
    <h2>Specify image URL to encode in Base64</h2>
    <p>This tool with encode the image at the specified http URL below</p>
    <form method="POST">
        <p>
            Image URL: <input type="text" name="url" /><br />
            <input type="submit" value="Encode" />
        </p>
    </form>
    <?php
}
else {
    if (isset($_POST['url'])) {
        $url = $_POST['url'];
        $file = fopen($url, 'r');
        $binarydata = stream_get_contents($file);
        fclose($file);
        if (strlen($url)>4 && substr($url, strlen($url)-4, 4)==".png")
            $subtype = 'png';
        else
            $subtype = 'jpeg';
    }
    else {
        $filename = $_FILES['image']['tmp_name'];
        $file = fopen($filename, 'r');
        $binarydata = fread($file, filesize($filename));
        fclose($file);
        $subtype = 'jpeg';
    }
    $rawBase64string = base64_encode($binarydata);
    $base64string = preg_replace('/.{100}/', '$0<br />', $rawBase64string);
    ?>
    <h2>Encoding statistics</h2>
    <p>Image was <?=strlen($binarydata) ?> bytes large. The Base64 string is now <?=strlen($base64string)?> characters.</p>
    <h2>Encoding result as img element</h2>
    <p>
        <button onclick="select();">Select img tag for copying</button><br />
        After selecting, you need to copy it to the clipboard manually using Control-C or the browser's copy command.
    </p>
    <p id="output">
        &lt;img src="data:image/<?php echo $subtype;?>;base64,<?php echo $base64string; ?>" /&gt;
    </p>
    <p>
        <img src="data:image/<?php echo $subtype;?>;base64,<?php echo $rawBase64string; ?>" />
    </p>
    <?php
}
?>
    <script>
    function select() {
        var output = document.getElementById("output");
        var range = document.createRange();
        range.selectNodeContents(output);
        var selection = window.getSelection();
        selection.removeAllRanges();
        selection.addRange(range);
    }
    </script>
    </li>
</ul>
