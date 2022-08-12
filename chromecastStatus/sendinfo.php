<?php
//require_once("class.log.php");
/*
//Logging
$logger = new log("api_logger.log");
file_put_contents("api_logger.log", "");
//
*/

require_once("dal.php");
require_once("helper.php");

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type:application/json");

if (isset($_GET['type']) && isset($_GET['activeMAC']) && isset($_GET['activeIP']) && isset($_GET['serverName']))
{
	$hostname = $_GET['hostname'];
	$activeMAC = $_GET['activeMAC'];
	$activeIP  = $_GET['activeIP'];
	$serverName = $_GET['serverName'];

	if($_GET['type'] == "ipbound")
	{
		$dbHandler2 = new DatabaseHandler("radius");
		$query = "select JSON_OBJECT('username', username, 'firstname', firstname, 'lastname', lastname) as Output from userinfo where username='$activeMAC'";
		$data = $dbHandler2->GetResult($query, "Output");
		$data = json_decode($data);

		$dbHandler = new DatabaseHandler("chromecast_telemetry");
		$insertedID = $dbHandler->SaveData($hostname, $activeMAC, $activeIP, $serverName, $data->lastname, $data->firstname);

		response(200, "INSERTED#".$insertedID, "SUCCESS");
	}
}
else if(isset($_GET['type']) && isset($_GET['eureka_info']))
{
	if($_GET['type'] == "devicedata" && $_GET['format'] == "json")
	{
		$deviceData = $_GET['eureka_info'];
		$deviceDataEncoded = json_encode($deviceData);
		$activeMAC = $_GET['activeMAC'];
		$dbHandler = new DatabaseHandler("chromecast_telemetry");
		$query = "update lastSeenInfo set chromecast_devicedata=$deviceDataEncoded where activeMAC='$activeMAC'";
		//echo $query;
		$result = $dbHandler->UpdateData($query);
		response(200, "UPDATED#".$result, "SUCCESS");
	}
}
else if(isset($_GET['type']) && isset($_GET['hotelcode']))
{
	$hotelcode = $_GET['hotelcode'];

	if($_GET['type'] == "reload_data")
	{
		$dbHandler2 = new DatabaseHandler("radius");
                $query = "select JSON_ARRAYAGG(JSON_OBJECT('username', username, 'firstname', firstname, 'lastname', lastname)) as Output from userinfo where firstname like '$hotelcode%'";
                $data = $dbHandler2->GetResult($query, "Output");
                $data = json_decode($data);

		$dbHandler = new DatabaseHandler("chromecast_telemetry");
		foreach($data as $item)
		{
                	$res = $dbHandler->SaveData("", $item->username, "", "", $item->lastname, $item->firstname, "n"); //"n" - means No
		}
		response(200, "RELOAD_DATA#DONE", "SUCCESS");
	}
}
else
{
	response(400, "BAD_REQUEST", "INVALID");
        exit(0);
}
//end
?>

