<?php
function checkid($id)
{
	if(!is_numeric($id))
	die("All links are numeric.");
	
	$link = "SELECT * FROM users WHERE id='$id'";
	$res = mysql_query($link) or die(mysql_error());
	@$totalnum = mysql_num_rows($res);
	
	if($totalnum == 0)
	die("No item exists with that ID.");
}

function ownedit($id)
{
	if ($_SESSION['admin'] != 1)
	{
		$link = "SELECT name FROM users WHERE id='$id'";
		$res = mysql_query($link) or die(mysql_error());
		$row = mysql_fetch_row($res);
		if ($row[0] != $_SESSION['name'])
		die("Please only edit your own settings and details.");
	}
}

function clean($string)
{ 
$cleanse = array("<",">","'",'"',"/");

	foreach ($cleanse as $val)
	{
		$string = str_replace($val,"",$string);
	}	

return $string;
}

function err($field)
{
	die("You either did not enter a value or the value was too large for: " . $field);
}

function admin()
{
	if ($_SESSION['admin'] != 1)
	die("<p>Sorry, only Admins can perform this action.</p>");
}
?>