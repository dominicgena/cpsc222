<?php
session_start();
$_SESSION = array();
session_destroy();
header("Location: /php/Exam2/final.php");
?>