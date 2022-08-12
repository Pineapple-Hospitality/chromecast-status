<?php
class DatabaseHandler
{
        //db properties
        private $host = "localhost";
        private $username = "root";
        private $password = "CwP.4k.R00t";
        //private $databasename = "chromecast_telemetry";
        private $con;

        function __construct($dbname)
        {
                $this->con = $this->connectDB($dbname);
        }

        private function connectDB($databaseName)
        {
                $con = mysqli_connect($this->host, $this->username, $this->password, $databaseName);

                // Check connection
                if ($con->connect_error){
                	die("Failed to connect to MySQL: " . $con->connect_error);
                }

                return $con;
        }

        function __destruct()
        {
                mysqli_close($this->con);
        }

        function SaveData($hostname, $activeMAC, $activeIP, $serverName, $roomNumber, $hotelCode, $lastSeen="y")
        {
		$hostname = mysqli_real_escape_string($this->con, $hostname);
		$activeMAC = mysqli_real_escape_string($this->con, $activeMAC);
		$activeIP = mysqli_real_escape_string($this->con, $activeIP);
		$serverName = mysqli_real_escape_string($this->con, $serverName);
		$roomNumber = mysqli_real_escape_string($this->con, $roomNumber);
		$hotelCode = mysqli_real_escape_string($this->con, $hotelCode);

		if($lastSeen == "y")
                {
			$sqlQuery = "REPLACE INTO lastSeenInfo(hostname,activeMAC,activeIP,serverName,roomNumber,hotelCode) values('$hostname','$activeMAC','$activeIP','$serverName','$roomNumber','$hotelCode')";
		}
		else
		{
			$sqlQuery = "REPLACE INTO lastSeenInfo(hostname,activeMAC,activeIP,serverName,seen_date,roomNumber,hotelCode) values('$hostname','$activeMAC','$activeIP','$serverName','1970-01-01 00:00:00','$roomNumber','$hotelCode')";
		}

                return $this->insertQuery($sqlQuery);
        }

        private function insertQuery($query)
        {
                $result = mysqli_query($this->con, $query);
                if (!$result) {
                    die('Invalid query: ' . mysqli_error($this->con));
                }
                else {
                    return mysqli_insert_id($this->con);
                }
        }

	function GetResult($sqlQuery, $nickname)
	{
		$output = "";

		$result = mysqli_query($this->con, $sqlQuery);
		if (mysqli_num_rows($result) > 0)
		{
			$row = mysqli_fetch_assoc($result);
			return $row["Output"];
		}
		else
		{
		}

		return $output;
	}

	function UpdateData($sqlQuery)
	{
		$result = mysqli_query($this->con, $sqlQuery);
		if ($result)
                {
			return "Success";
		}
		else
		{
			return "Error: ". mysqli_error($this->con);
		}
	}

}
?>

