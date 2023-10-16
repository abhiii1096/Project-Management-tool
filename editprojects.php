<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>Edit Project</title></head><body>';
include("table.php");

if (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] != 'POST')
{
	$id = clean($_GET['id']);
	if (empty($id) || !is_numeric($id))
	die("Please only follow the links on the page.");
	
	$link = "SELECT * FROM projects WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	$total = mysql_num_rows($res);
	$row = mysql_fetch_assoc($res);
	$priv = $row['private'];
	//print_r(array_values($row)); die;
	//ho $_SESSOIN['admin'];
	if ($priv == 1 && $_SESSION['admin'] != 1)
	die("An admin has marked this project un-editable.");
	
	
	if ($total == 0)
	die("<p>No project exists with this id.</p>");
	
	
	echo '<br />
	<form action="" method="POST">'
	. $tablehead . '
	<tr>
	<td colspan="2" class="heading">
	edit project
	</td>
	</tr>
	<tr>
	<td>name</td>
	<td><input type="text" name="name" value="' . $row['name'] . '">
	</td>
	</tr>
	<tr>
	<td>date</td>
	<td><input type="text" name="date" value="' . $row['date'] . '">
	</td>
	</tr>
	<tr>
	<td valign="top">description</td>
	<td><textarea name="des" rows="10" cols="40">' . $row['des'] . '</textarea>' . '
	</td>
	</tr>
	<tr>
	<td>category</td>
	<td><select name="cat">';
	$link1 = "SELECT * FROM category";
	$res1 = mysql_query($link1);
	$cur = $row['cat'];
	$x = 0;
	while ($row1 = mysql_fetch_row($res1))
	{	
		$cat = $row1[0];
		if ($cat == $cur && $x != 1)
		{
		echo '<option value="' . $cat . '" selected>' . $cat;
		$x = 1;		
		}
		else
		echo '<option value="' . $cat . '">' . $cat;
	}	
	echo '</select></td></tr>
	<tr><td>status</td>
	<td><select name="status">';
	
	$link2 = "SELECT * FROM status";
	$res2 = mysql_query($link2);
	$stat = $row['status'];
	$x = 0;
	while ($row2 = mysql_fetch_row($res2))
	{	
		$status = $row2[0];
		if ($stat == $status && $x != 1)
		{
		echo '<option value="' . $status . '" selected>' . $status;
		$x = 1;
		}
		else
		echo '<option value="' . $status . '">' . $status;
	}
	echo '</select><br />
	<tr><td>sort</td>
	<td><input type="text" name="sort" value="' . $row['sort'] . '"></td></tr>
	<tr><td>private</td>';
	if ($priv == 1)
	echo '<td><input type="checkbox" name="private" checked></td></tr>';
	else
	echo '<td><input type="checkbox" name="private"></td></tr>';
	echo '
	<tr><td>last changed</td>
	<td>' . $row['last_changed'] . '</td></tr>
	<tr><td>last user</td>
	<td>' . $row['last_user'] . '</td></tr>
	<tr>
	<td>Delete</td>
	<td><input type="checkbox" name="delete"></td>
	</tr>
	<tr>
	<td colspan="2">
	<input type="hidden" name="id" value="' . $id . '">
	<input type="submit" value="Update"></td></tr></form></table>';
	
}
elseif ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$id = clean($_POST['id']);	
	$status = clean($_POST['status']);	
	$name = clean($_POST['name']);
	$date = $_POST['date'];
	$des = clean($_POST['des']);
	$cat = clean($_POST['cat']);
	@$delete = $_POST['delete'];	
	$sort = clean($_POST['sort']);
	@$priv = clean($_POST['private']);	
	$time = date("h:i:s A");
	$d = date("n/j/Y");
	$change = $d . " " . $time;	
	$n = $_SESSION['user'];
	
	$need = array($status,$name,$date,$des,$cat,$sort);
	foreach ($need as $val)
	{
		if (empty($val))
		die("You did not fill out all required fields.");
	}
	if (!is_numeric($sort))
	die("The sort value must be a whole number.");

	
	if ($priv == 'on')
	$priv = 1;
	else
	$priv = 0;
	
	//echo "priv is " . $priv; die;
	
	$set = "name='$name',`date`='$date',des='$des',cat='$cat',sort='$sort',last_changed='$change',private='$priv',last_user='$n',status='$status'";
	
	
	$link = "SELECT * FROM projects WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	$total = mysql_num_rows($res);
	if ($total == 0)
	die("No Projects exist by this id.");
	
	if ($delete == 'on')
	{
		admin();
		$link = "DELETE FROM projects WHERE id='$id'";
		$res = mysql_query($link) or die(mysql_error());
		if ($res)
		die('<br /><br />Project Succesfully Deleted.<br />Click <a href="index.php">here</a> to go back.');
	}	
	
	$link = "UPDATE projects SET $set WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	if ($res)
	die('<p>succesfully updated.<br />click <a href="projects.php">here</a> to continue.</p>');
}
else
die('You should not be seeing this.<br />Click <a href="index.php">here</a> to go back.');
?>
	
	