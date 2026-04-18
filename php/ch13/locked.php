<?php
session_start();
session_destroy();
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Locked</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <h1>Session locked</h1>
        <?php
        $exception = $_GET['exception'];
        if (empty($exception)) {
            echo "<h1>You seem evil, please go away :(</h1>";
        }
        else {
            echo "An error has occurred. Please try again later.<br>Error: " . $exception;
        }
        ?>
        
    </body>
</html>