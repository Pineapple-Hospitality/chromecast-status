<?php
$mac_address = $_GET['mac'];
if(isset($mac_address) == false)
{
	echo "Wrong parameter(s)!";
	exit(0);
}

require_once("dal.php");
$dbHandler = new DatabaseHandler("radius");
$query = "select JSON_OBJECT('username', username, 'firstname', firstname, 'lastname', lastname) as Output from userinfo where username='$mac_address'";
$data = $dbHandler->GetResult($query, "Output");
echo $data;
?>

