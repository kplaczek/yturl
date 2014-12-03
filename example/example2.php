<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        include_once '../yturl.php';
        if (isset($_POST['vid'])) {
            $yturl = new yturl($_POST['vid']);
            $streams = $yturl->getInfo();
            foreach ($streams as $stream) {
                if (strpos($stream['type'], ';'))
                    list($type, $codec) = explode(';', $stream['type']);
                else
                    $type = $stream['type'];
                echo '<div><video controls><source type="' . $type . '" src="' . $stream['url'] . '"></video></div>';
            }
        }
        ?>
        <form method="post" action="example2.php">
            <input name="vid"><input type="submit">
        </form>
    </body>
</html>
