<?php
include("connect.php");
include("functions.php");
echo '<title>Login</title></head><body>';
include("table.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$name = clean($_POST['username']);
	$pass = clean($_POST['password']);
	$ip = $_SERVER['REMOTE_ADDR'];
	
	if (empty($name))
	err('name');
	if(empty($pass))
	err('password');
	$pass = md5($pass);
	
	$link = "SELECT * FROM users WHERE name='$name' AND password='$pass'";
	$res = mysql_query($link) or die(mysql_error());
	$total = mysql_num_rows($res);
	
	if($total == 0)
	die("<br />username/password could not be verfied please try again.");
	else
	{
		$row = mysql_fetch_assoc($res);		
		$id = $row['id']; $ip = $_SERVER['REMOTE_ADDR'];
		$_SESSION['admin'] = $row['admin'];
		$_SESSION['user'] = $name;
		$link = "UPDATE users SET`date`=NOW(),`ip`='$ip' WHERE id='$id'";
		$res = mysql_query($link) or die(mysql_error());		
		die("<p class='heading'>succesfully logged in</p><p>choose a menu item from above</p>");
	}
}
else
{
echo '<br />
<form action="" method="POST">
' . $tablehead . '
<tr><td colspan="2" class="heading">login</td></tr>
<tr><td>Username</td><td><input type="text" name="username"></td></tr>
<tr><td>Password</td><td><input type="text" name="password"></td></tr>
<tr><td colspan="2"><input type="submit" value="login"></td></tr></form>
</table>';
}
?>


