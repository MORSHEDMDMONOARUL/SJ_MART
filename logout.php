<?php
session_start();
session_destroy();
header('Location: login.php');
exit();
?>
<!--colisng session and getting back to login page-->