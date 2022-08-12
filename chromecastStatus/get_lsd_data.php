<?php
$filter = $_GET['hotelcode'];
if(isset($filter) == false)
{
        //echo "Missing hotelcode filter!";
        //exit(0);
}

require_once("dal.php");
$dbHandler = new DatabaseHandler("chromecast_telemetry");
$sqlQuery = "SELECT JSON_OBJECT('data', JSON_ARRAYAGG(JSON_OBJECT('Hostname', hostname, 'activeMAC', activeMAC, 'activeIP', activeIP, ";
$sqlQuery .= "'serverName', serverName, 'seen_date', seen_date, 'roomNumber', roomNumber, 'hotelCode', hotelCode, 'signalStrength', signalStrength, 'chromecast_devicedata', chromecast_devicedata))) as Output from lastSeenInfo;";
$data = $dbHandler->GetResult($sqlQuery, "Output");

$tmpData = json_decode($data);
$nowDT = date_create();
$cnt = 0;

foreach($tmpData->data as $item)
{
	$dateDiff = date_diff(date_create($item->seen_date), $nowDT);
	$hours = $dateDiff->h;
	$hours = $hours + ($dateDiff->days*24);
	$item->seen_date = $hours." hour(s)";
	$item->hotelCode = substr($item->hotelCode, 0, strpos($item->hotelCode, " Chromecast"));
	$tmpData->data[$cnt++] = $item;
}
$data = json_encode($tmpData);
echo $data;
?>
