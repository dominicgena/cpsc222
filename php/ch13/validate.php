<?php
$username = sanitize($_POST['username'], 'username');
$password = sanitize($_POST['password'], 'password');
$incorrect = preg_replace("/\D/", "", htmlspecialchars($_GET['incorrect']));

$correctUsername = "admin";
$correctPassword = "password";
include_once('/php/ch13/logout.php');

if ($username != $correctUsername || $password != $correctPassword) {
    try {
        $incorrectCount = (int) $incorrect;
        $incorrectCount += 1;
    } catch(Exception $e) {// if user is evil
        header("Location: /php/ch13/locked.php?exception=$e");
    }
    
    header("Location: /php/ch13/index.php?incorrect=$incorrectCount");
}

else {
    session_start();
    $_SESSION['LOGGEDIN'] = 1;
    $_SESSION['username'] = $username;
    header("Location: /php/ch13/session.php");
}

function sanitize($string, $type) {
    $input = htmlspecialchars($string);
    // if it's a username, only case insensitive ("/i") alphanumeric should be accepted
    if($type == 'username') return preg_replace("/[^a-z0-9]/i", "", $input);
    // if it's a password, we should also accept some special characters for user security
    return preg_replace("/[^a-zA-Z0-9!#$%&*_\-]/", "", $input);
}
?>