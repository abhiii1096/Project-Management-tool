<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>Edit Category</title></head><body>';
include("table.php");

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] != 'POST')
{
	$id = clean($_GET['id']);
	if (empty($id) || !is_numeric($id))
	die("Please only follow the links on the page.");
	
	$link = "SELECT * FROM category WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	$total = mysql_num_rows($res);
	
	if ($total == 0)
	die("Error, invalid record.");
	
	$link = "SELECT * FROM category WHERE id='$id'";
	$res =mysql_query($link) or die(mysql_error());
	$row = mysql_fetch_row($res);
	
	echo '<br />
	<form action="" method="POST">
	' . $tablehead . '
	<tr>
		<td class="heading" colspan="2">edit category</td>
	</tr>
	<tr>
		<td>name</td>
		<td><input type="text" name="cat" value="' . $row[0] . '"></td>
	</tr>	
	<tr>
	<td><input type="checkbox" name="delete">delete</td>
	<td><input type="submit" value="Update Category">
	<input type="hidden" name="id" value="' . $id . '">
	</td>
	</tr></form>
	</table>
	';
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$id = clean($_POST['id']);	
	
	$cat = clean($_POST['cat']);		 
	@$delete = $_POST['delete'];	
	
	if ($delete == 'on')
	{
		admin();
		
		$link = "SELECT * FROM projects WHERE cat='$cat'";
		$res = mysql_query($link) or die(mysql_error());
		$total = mysql_num_rows($res);
		if ($total > 0)
		die("Can not delete this because a project is using it.");
		
		$link = "DELETE FROM category WHERE id='$id'";
		$res = mysql_query($link) or die(mysql_error());
		if ($res)
		die('Category Succesfully Deleted.<br />Click <a href="index.php">here</a> to go back.');
	}	
	
	if (empty($cat))
	die("Please go back and enter a status.");			
	
	$link = "UPDATE category SET cat='$cat' WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	if ($res)
	die('<p>succesfully updated.<br />click <a href="cat.php">here</a> to continue.</p>');
}
else
die('You should not be seeing this.<br />Click <a href="index.php">here</a> to go back.');
?>
	
	