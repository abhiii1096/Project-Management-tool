<?php
session_start();

$host = "localhost";
$databasename = "phpproject";
$databaseuser = "root";
$databasepassword = "password";

mysql_connect($host,$databaseuser,$databasepassword);
if ($ex != "no")
mysql_select_db($databasename);
//
$tablehead = '<table border="1" cellspacing="0" cellpadding="4" bordercolor="#999999">';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="stylesheet" href="style.css" type="text/css" />