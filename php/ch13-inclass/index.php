<?php
session_start();

// $_SESSION['LOGGEDIN'] = 1;
// $_SESSION['USER'] = 'joe';

// IMPORTANT: header only works BEFORE anything is printed to the screen
// header('Location: /info.php');

print_r($_SESSION, 0);
$hosts = fopen('/etc/hosts', 'r') or die('Unable to open');
$linearr = array();
// echo fgets($hosts);
while($line = fgets($hosts)) {
    if(!feof($hosts)) {
        $linearr[] = preg_split("/\s+/", trim($line));
    }
}

fclose($hosts);
print_r($linearr, 0);
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Chapter 13</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width">
    </head>
    <body>

        <a href="/php/ch13/logout.php">Log out</a>
    </body>
</html>