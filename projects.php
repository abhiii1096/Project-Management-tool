<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>Projects Main</title></head><body>';
include("table.php");
$sort = "";
$how = "ASC";
$went = 1;

if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
	$ids = $_POST['ids'];
	$order = implode(",",$_POST);
	$order = str_replace($ids,"",$order);
	$order = substr($order,0,strlen($order)-1);
	$ids = explode(",",$_POST['ids']);
	$order = explode(",",$order);
	$x = 0;
	
	foreach ($order as $val)
	{
	$id = $ids[$x];
	if (!is_numeric($id) || !is_numeric($val))
	{
	$x++;
	continue;
	}	
	$link = "UPDATE projects SET sort='$val' WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	$x++;
	}

}
	

if (isset($_GET['action']))
{
	$action = clean($_GET['action']);
	$user = $_SESSION['user'];
	if ($action == 1)
	{
		$date = date("n/j/Y");
		$link = "INSERT INTO projects VALUES ('-New Project-','$date','','','','','0',NOW(),'$user','')";
		$res = mysql_query($link) or die(mysql_error());
	}
	else
		echo "<p class='heading'>Invalid Action</p>";
}

if (isset($_GET['sort']))
{
	if (isset($_GET['went']))
	{
	if ($_GET['went'] == 2)
	{
		$how = "DESC";
		$went = 1;
	}
	elseif($_GET['went'] == 1)
	{
		$how = "ASC";
		$went = 2;
	}
	else
	{
	$how = "ASC";
	$went = 1;
	}
	}
	else
	{
	$went = 1;
	}
	$good = array("sort","name","date","cat","status","last_changed");
	$sort = $_GET['sort'];
	if (!in_array($sort,$good))
	die("Invalid sort column.");
}

echo '<br /><a href="projects.php?action=1">create a new project</a><br /><br />';

if (empty($sort))
$sort = "sort";

$link = "SELECT * FROM projects ORDER BY $sort $how";
$res = mysql_query($link) or die(mysql_error());
$total = mysql_num_rows($res);

echo $tablehead . '
<tr>
<td colspan="6" class="heading">projects</td>
</tr>
<tr align="center">
<td>
<a href="projects.php?sort=sort&went=' . $went. '">order</a>
</td>
<td>
<a href="projects.php?sort=name&went=' . $went . '">name</a>
</td>
<td>
<a href="projects.php?sort=date&went=' . $went . '">date</a>
</td>' . 
'<td>
<a href="projects.php?sort=cat&went=' . $went . '">category</a>
</td>
<td>
<a href="projects.php?sort=status&went=' . $went . '">status</a>
</td>' .
'<td>
<a href="projects.php?sort=last_changed&went=' . $went . '">change</a>
</td>
</tr>
<form action="" method="POST">';

$ids = "";
$x = 0;

while ($row = mysql_fetch_assoc($res))
{

$name = $row['name'];
$date = $row['date'];
$des = $row['des'];
$cat = $row['cat'];
$status = $row['status'];
$sort = $row['sort'];
$private = $row['private'];
$change = $row['last_changed'];
$id = $row['id'];
$ids .= $id . ",";


echo '<tr><td><input type="text" name="sort' . $x . '" value="' . $sort . '" size="5">&nbsp;</td><td nowrap><a href="editprojects.php?id=' . $id . '">' . $name . '</a>&nbsp;</td><td nowrap>' . $date .  '&nbsp;</td>' . 
'<td>' . $cat . '&nbsp;</td><td>' . $status . '&nbsp;</td><td nowrap>' . $change . '&nbsp;</td></tr>';
$x++;
}

$ids = substr($ids,0,strlen($ids)-1);

echo '<tr><td colspan="6" bgcolor="#8FABBE"><input type="submit" value="Update Order"><input type="hidden" name="ids" value="' . $ids . '"></td></tr></table></form>';

$time = date("h:i:s A");
$date = date("n/j/Y");

echo '<br /><small>';
echo $date . '  ' . $time;
echo ' - projects:' . $total;
echo ' - current user:' . $_SESSION['user'];
echo '<br><a href="http://phpproject.us" class="nodec" style="color: black;">php project</a> ';
echo '</small>';
?>

