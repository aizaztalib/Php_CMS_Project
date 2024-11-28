<?php
session_start();
$_SESSION = array(); 
session_destroy(); 
header("Location: ../includes/login.php"); 
exit();
?>
