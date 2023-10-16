<?php
include("connect.php");
include("loggedin.php");
include("functions.php");
echo '<title>Status</title></head><body>';
include("table.php");

if (isset($_GET['action']))
{
	$action = clean($_GET['action']);
	
	if ($action == 1)
	{
		$link = "INSERT INTO status VALUES ('new status','')";
		$res = mysql_query($link) or die(mysql_error());
	}
	else
		echo "<p>Invalid Action</p>";
}

echo '<br /><a href="status.php?action=1">create a new status</a><br /><br />';

$link = "SELECT * FROM status";
$res = mysql_query($link) or die(mysql_error());
$total = mysql_num_rows($res);

echo $tablehead . ' <tr><td class="heading">status</td></tr>';

while ($row = mysql_fetch_assoc($res))
{
	$status = $row['status'];
	$id = $row['id'];		
	
	echo '<tr><td><a href="editstatus.php?id=' . $id . '">' . $status . ' ( ' . $id . ' )</a> </td></tr>';
}

echo '</table>';
echo '<br />total: ' . $total . '</body></html>';
?>




	
	
	
	
	
	