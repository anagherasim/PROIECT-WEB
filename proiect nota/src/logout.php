<?php
session_start();
unset($_SESSION["myuser"]);
header("Location: index.php"); 
exit;
?>