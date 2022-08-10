<?php
$mac_address = $_GET['mac'];
if(isset($mac_address) == false)
{
        echo "Wrong parameter(s)!";
        exit(0);
}

require_once("dal.php");
$dbHandler = new DatabaseHandler("chromecast_telemetry");
$sqlQuery = "SELECT activeIP as Output FROM lastSeenInfo WHERE activeMAC='$mac_address';";
$data = $dbHandler->GetResult($sqlQuery, "Output");
echo $data;;
?>
