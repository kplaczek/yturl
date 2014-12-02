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
                echo '<div><video controls><source src="' . $stream['url'] . '"></video></div>';
            }
        }
        ?>
        <form method="post" action="example2.php">
            <input name="vid"><input type="submit">
        </form>
    </body>
</html>
