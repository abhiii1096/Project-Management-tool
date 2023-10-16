<?php
$ex = "no";
include("connect.php");

$table = "DROP DATABASE IF EXISTS " . $databasename;
//$res = mysql_query($table) or die(mysql_error());

$table = "CREATE DATABASE `" . $databasename . "`";
$res = mysql_query($table) or die(mysql_error());

mysql_select_db($databasename);

$table = "
CREATE TABLE `category` (
  `cat` varchar(150) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1 ;";
$res = mysql_query($table) or die(mysql_error());


$table = "CREATE TABLE `projects` (
  `name` varchar(150) NOT NULL default '',
  `date` varchar(40) NOT NULL default '',
  `des` text NOT NULL,
  `cat` text NOT NULL,
  `status` varchar(150) NOT NULL default '',
  `sort` int(11) NOT NULL default '0',
  `private` text NOT NULL,
  `last_changed` varchar(50) NOT NULL default '',
  `last_user` varchar(50) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1 ;";
$res = mysql_query($table) or die(mysql_error());

$table = "CREATE TABLE `status` (
  `status` varchar(200) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1 ;";
$res = mysql_query($table) or die(mysql_error());

$table = "
CREATE TABLE `users` (
  `name` varchar(50) NOT NULL default '',
  `password` text NOT NULL,
  `date` varchar(20) NOT NULL default '',
  `ip` varchar(15) NOT NULL default '',
  `id` int(11) NOT NULL auto_increment,
  `admin` enum('0','1') NOT NULL default '0',
  PRIMARY KEY  (`id`)
) AUTO_INCREMENT=1 ;";
$res = mysql_query($table) or die(mysql_error());


$table ="INSERT INTO `users` VALUES ('User123', '0cc175b9c0f1b6a831c399e269772661', '2005-06-21 15:01:04', '192.168.1.1', 1, '1');";
$res = mysql_query($table) or die(mysql_error());

die("<p>All tables have been successfully created. You can log in with the values of username: User123 and password: a<br><strong>Please delete or rename this file for security reasons.</strong></p>");
?>

