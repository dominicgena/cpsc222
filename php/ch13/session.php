<?php
session_start();

if ($_SESSION['LOGGEDIN'] != 1) {
    // if they aren't logged in, kick them back to the login
    header("Location: /php/ch13/index.php");
    session_destroy();
}

$username = $_SESSION['username'];
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title><?php echo $username;?>'s Session</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <h1>Hello, <?php echo $username;?></h1>
        <a href="/php/ch13/logout.php">Log out</a>
    </body>
</html>