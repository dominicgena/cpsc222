<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Chapters 7 & 12 - Date Formatter</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
<?php
// "^" = "!"
// $fname = preg_replace('/[^a-zA-Z]/', '', $_POST['fname']);
echo "<h1>Birthdate Formatter</h1>\n";

// user just submitted form
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $month = $_POST['month'];
    $day = $_POST['day'];// e.g., 31
    $year = $_POST['year'];
    $hour = $_POST['hour'];
    $minute = $_POST['minute'];
    $meridiem = $_POST['meridiem'];
    $monthNum = date('n', strtotime($month));
    // these are all strings
    
    $timestampString = "$year-$monthNum-$day $hour:$minute $meridiem";
    $timestamp = strtotime($timestampString);
    $processedTimestamp = preg_replace('/[^0-9-]/', '', $timestamp);// just in case
    $dateTimeString = date('l F jS, Y - g:i A', substr($processedTimestamp, 0, 20));
    echo "<p style=\"text-indent: 1em;font-size:18pt;\">" . $dateTimeString . "</p>";
    echo "<br><br><a style=\"margin-left: 1em;font-size:18pt;\" href=?format=iso&timestamp=$processedTimestamp>Show date in ISO format</a>";
}

// user requested iso format
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['format'] == 'iso') {
    $timestamp = substr(preg_replace('/[^0-9-]/', '', $_GET['timestamp']), 0, 20);
    $iso = date('Y-m-d H:i:s', $timestamp);
    echo "<p style=\"text-indent: 1em;font-size:18pt;\">" . $iso . "</p>";
    echo "<br><br><a style=\"margin-left: 1em;font-size:18pt;\" href=?format=original&timestamp=$timestamp>Show date in original format</a>";
}

// user wants original format again
else if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_GET['format'] == 'original') {
    $timestamp = substr(preg_replace('/[^0-9-]/', '', $_GET['timestamp']), 0, 20);
    $date = date('l F jS, Y - g:i A', $timestamp);
    echo "<p style=\"text-indent: 1em;font-size:18pt;\">" . $date . "</p>";
}

// user is trying to break the server
else {
    echo "<h2 style=\"text-indent: 1em;font-size:18pt;\">Client error: Invalid request</h2>";
}
?>
    </body>
</html>