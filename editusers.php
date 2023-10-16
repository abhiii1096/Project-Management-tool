<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>Edit Users</title></head><body>';
include("table.php");

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] != 'POST')
{
	$id = clean($_GET['id']);
	checkid($id);
	
	$link = "SELECT name,password FROM users WHERE id='$id'";
	$res =mysql_query($link) or die(mysql_error());
	$row = mysql_fetch_row($res);
	
	echo '<br />
	<form action="" method="POST">
	' . $tablehead . '
	<tr>
		<td class="heading" colspan="2">Edit User</td>
	</tr>
	<tr>
	<td>Username</td>
	<td><input type="text" name="name" value="' . $row[0] . '"></td>
	</tr>
	<tr>
	<td>New Password</td><td><input type="text" name="password"></td>
	</tr>
	<tr>
	<td>Make User an Admin (Must be admin)</td><td><input type="checkbox" name="admin"></td>
	</tr>
	<tr>
	<td>Delete User</td><td><input type="checkbox" name="delete"></td>
	</tr>
	<td colspan="2"><input type="submit" value="Update Details">
	<input type="hidden" name="id" value="' . $id . '">
	</td>
	</tr>
	</form>
	</table>
	';
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$id = clean($_POST['id']);
	checkid($id);
	
	$name = clean($_POST['name']);
	$password = clean($_POST['password']);	 
	@$delete = $_POST['delete'];
	@$admin = $_POST['admin'];
	
	if ($delete == 'on' && $admin == 'on')
	die("You can not make a member admin while deleting him or her");
	
	if ($delete == 'on')
	{
		admin();
		$link = "DELETE FROM users WHERE id='$id'";
		$res = mysql_query($link) or die(mysql_error());
		if ($res)
		die('User Succesfully Deleted.<br />Click <a href="index.php">here</a> to go back.');
	}
	if ($admin == 'on')
	{
		admin();
		$link = "UPDATE users SET admin='1' WHERE id='$id'";
		$res = mysql_query($link) or die(mysql_error());	
//echo $link; die;		
		if ($res)
		echo 'User now has Admin Status.<br />';
	}
		
	
	$set = "";
	
	if (!empty($name) && !empty($password))
	{
	$password = md5($password);
	$set = "name='$name',password='$password'";
	}
	else if(!empty($password))
	{
		$password = md5($password);
		$set = "password='$password'";
	}
	elseif (!empty($name))
		$set = "name='$name'";
	else
		die('You did not enter anything.<br /><a href="editusers.php?id=' . $id . '">Try Again</a>');
		
	
	ownedit($id);
	$link = "UPDATE users SET $set WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	if ($res)
	die('<p>succesfully updated.<br />click <a href="users.php">here</a> to continue.</p>');
}
else
die('You should not be seeing this.<br />Click <a href="index.php">here</a> to go back.');
?>
	
	