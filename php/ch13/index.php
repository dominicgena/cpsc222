<?php

// $_SESSION['LOGGEDIN'] = 1;
// $_SESSION['USER'] = 'joe';

// IMPORTANT: header only works BEFORE anything is printed to the screen
// header('Location: /info.php');
session_start();
if($_SESSION['LOGGEDIN'] == 1) {
    header('Location: /php/ch13/session.php');
}

if($_GET['logout'] == "true") {
    session_start();
    session_destroy();
    header('Location: /php/ch13');
}
?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>Login</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <h1>Login</h1>
        <?php
        // check for and hendle invalid login.
        $incorrect = $_GET['incorrect'];
        if(!empty($incorrect)){
            if (4 <= $incorrect) {
                header("Location: /php/ch13/locked.php");
            }
            echo "<h3 style=\"margin-left: 10px\";>Incorrect login...</h3>\n";
            if(1 < $incorrect && $incorrect < 3) {
                echo "<h3 style=\"margin-left: 10px\";>Wow, you really suck at logging in.</h3>\n";
            } else if (3 <= $incorrect) {
                echo "<h3 style=\"margin-left: 10px\";>Your shear stupidity is astounding!</h3>\n";
            }
        }
        ?>
        <form method="POST" action="validate.php?incorrect=<?php echo $incorrect . "\""?>>
            <div id="login" style="display: flex;flex-direction: column;width: 15vw;">
                <div id="un-container" style="padding: 10px;display: flex;flex-direction:row;">
                    <label for="username" style="margin-right: 8px;">Username:</label>
                    <input id="username" name="username">
                </div>
                <div id="pw-container" style="padding: 10px;display: flex;flex-direction:row;">
                    <label for="password" style="margin-right: 8px;"> Password:</label>
                    <input type="password" id="password" name="password">
                </div>
                <input 
                    <?php
                    // determine the message in the submit button by login attempt validity
                    $incorrect = $_GET['incorrect'];
                    if(!empty($incorrect)) {
                        if ($incorrect < 2) { echo "value=\"Try again\""; }
                        else { echo "value=\"Bro thinks he's Elliot Alderson\""; }
                    }
                    else {
                        echo "value=\"Log in\"";
                    }
                    ?>
                    type="submit" style="padding: 5px;margin-top: 5px; width: 90%;align-self: center;border: 2px solid white; color: black; background-color: white;">
            </div>
        </form>
    </body>
</html>