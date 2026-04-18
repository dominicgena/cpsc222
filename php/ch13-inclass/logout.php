<?php
session_start();// instead of checking if the session is actually active; don't kill a session that doesn't exist
$_SESSION = array();
session_destroy();
header('Location: /php/ch13/index.php');
?>