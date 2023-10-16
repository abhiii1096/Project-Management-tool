<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>Categories</title></head><body>';
include("table.php");

if (isset($_GET['action']))
{
	$action = clean($_GET['action']);
	
	if ($action == 1)
	{
		$link = "INSERT INTO category VALUES ('New Category','')";
		$res = mysql_query($link) or die(mysql_error());
	}
	else
		echo "Invalid Action";
}

echo '<br /><a href="cat.php?action=1">create a new category</a><br /><br />';

$link = "SELECT * FROM category";
$res = mysql_query($link) or die(mysql_error());
$total = mysql_num_rows($res);

echo $tablehead .
'<tr><td class="heading">category</td></tr>';


while ($row = mysql_fetch_assoc($res))
{
	$cat = $row['cat'];	
	$id = $row['id'];
	
	echo '<tr><td><a href="editcat.php?id=' . $id . '">' . $cat . '( ' . $id . ' )
	</td></tr>';
}

echo '</table>';
echo '<br />total categories: ' . $total . '</body></html>';
?>




	
	
	
	
	
	