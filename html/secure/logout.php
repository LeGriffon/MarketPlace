<?php session_start(); /* Starts the session */
session_save_path('/cgi-bin/tmp');
session_destroy(); /* Destroy started session */
header("location:../../login.php");
exit;
?>
