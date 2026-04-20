<?php
$arr = $_POST;
foreach ($arr as $key => $value) {
    if (!$value || $value == "") header("Location: /php/final/profile_builder.php?error=incomplete");
}

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Student Profile Summary</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width"/>
  </head>
  <body>
    <h1>Student Profile Summary</h1>
    <table style="border:2px solid black;">
    <?php
    $arr = $_POST;
    foreach ($arr as $key => $value) {
        echo "<tr>";
        $title = "";
        if ($key == "fname") $title = "First Name";
        if ($key == "lname") $title = "Last Name";
        if ($key == "major") $title = "Major";
        if ($key == "flang") $title = "Favorite Language";
        if ($key == "hobby") $title = "Hobby";
        echo "<td style=\"border:1px solid black;width:30%;\">$title</td><td  style=\"border:1px solid black;width:30%;\">$value</td>";
    }
    ?>
    </table>
  </body>
</html>