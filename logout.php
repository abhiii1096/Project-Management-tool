<?php
session_start();
session_destroy();
echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><link rel="stylesheet" href="style.css" type="text/css" /><title>Logout</title></head><body>';
include("table.php");
die("<p class='heading'>succesfully logged out.</p><p><a href='login.php' title='login again'>login again</p>");
echo'</body></html>';
echo
?>