<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>System Users</title></head><body>';
include("table.php");

if (isset($_GET['action']))
{
	$action = clean($_GET['action']);
	
	if ($action == 1)
	{
		$link = "INSERT INTO users VALUES ('User','','','','','0')";
		$res = mysql_query($link) or die(mysql_error());
	}
	else
		echo "<p>Invalid Action</p>";
}

echo '<br /><a href="users.php?action=1">create a new user</a><br /><br />';

$link = "SELECT * FROM users";
$res = mysql_query($link) or die(mysql_error());
$total = mysql_num_rows($res);

echo $tablehead . 
'<tr><td colspan="3" class="heading">users</td></tr>
<tr><td>name</td><td>last login</td><td>login ip</td></tr>';


while ($row = mysql_fetch_assoc($res))
{
	$name = $row['name'];
	$date = $row['date'];
	$ip = $row['ip'];
	$id = $row['id'];
	
	//print_r(array_values($row)); die;
	
	echo '<tr><td><a href="editusers.php?id=' . $id . '">' . $name . '( ' . $id . ' )&nbsp;</td>' . 
	'<td>' . $date . '&nbsp;</td><td>' . $ip . '&nbsp;</td></tr>';
}

echo '</table>';
echo '<br />total users: ' . $total . '</body></html>';
?>




	
	
	
	
	
	