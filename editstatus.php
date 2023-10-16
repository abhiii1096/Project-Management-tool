<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>Edit Status</title></head><body>';
include("table.php");

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] != 'POST')
{
	$id = clean($_GET['id']);
	if (empty($id) || !is_numeric($id))
	die("<p>please only follow the links on the page.</p>");
	
	$link = "SELECT * FROM status WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	$total = mysql_num_rows($res);
	$row = mysql_fetch_row($res);
	
	if ($total == 0)
	die("<p>no status exists for this id, please try again.</p>");
	
	echo '<br />
	<form action="" method="POST">'
	. $tablehead . '
	<tr><td colspan="2" class="heading">edit status</td></tr>
	<tr><td>name</td><td><input type="text" name="status" value="' . $row[0] . '"></td></tr>	
	<input type="hidden" name="id" value="' . $id . '">
	<td><input type="checkbox" name="delete">Delete</td>
	<td><input type="submit" value="Update Status"></td>
	</tr></form>
	</table>
	';
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$id = clean($_POST['id']);
	
	$status = clean($_POST['status']);		 
	@$delete = $_POST['delete'];	
	
	if ($delete == 'on')
	{
		admin();
		$link = "SELECT * FROM projects WHERE status='$status'";
		$res = mysql_query($link) or die(mysql_error());
		$total = mysql_num_rows($res);
		if ($total > 0)
		die("Unable to delete this status. Another a project is using it.");
		
		$link = "DELETE FROM status WHERE id='$id'";
		$res = mysql_query($link) or die(mysql_error());
		if ($res)
		die('Status Succesfully Deleted.<br />Click <a href="index.php">here</a> to go back.');
	}	
	
	if (empty($status))
	die("Please go back and enter a status.");			
	
	$link = "UPDATE status SET status='$status' WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	if ($res)
	die('<p>succesfully updated.<br />click <a href="status.php">here</a> to continue.</p>');
}
else
die('You should not be seeing this.<br />Click <a href="index.php">here</a> to go back.');
?>
	
	