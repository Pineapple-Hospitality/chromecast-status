/var/www/html/api/radiusAdd.php
<?PHP
       $servername = "localhost";
        $db_username = "root";
        $db_password = "CwP.4k.R00t";
        $db_name = "radius";

        // Create connection
        $conn = new mysqli($servername, $db_username, $db_password, $db_name);

        if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
        }

     $lname = "";
        $rn = "";
        $mac = "";
        $resortid = "";

        if ( !empty ( $_GET ) ){
                if ( !empty ( $_GET['rn'] ) ){
                        $rn = $_GET['rn'];
                }
                else{
                        echo "Error: 911 :) Room Number not provided";
                }
                if ( !empty ( $_GET['mac'] ) ){
                        $mac = $_GET['mac'];
                }
                else{
                        echo "Error: 911 :) MAC address not provided";
                }
                if ( !empty ( $_GET['resortid'] ) ){
                        $resortid = $_GET['resortid'];
                }
                else{
                        echo "Error: 911 :) resortid not provided";
                }
        }

$sql1 = "INSERT INTO radcheck ( username, attribute, op, value ) VALUES ( '$mac', 'Auth-Type', ':=', 'Accept' )";
$sql2 = "INSERT INTO radreply ( username, attribute, op, value ) VALUES ( '$mac', 'Tunnel-Private-Group-ID', ':=', '$rn' )";
$sql3 = "INSERT INTO userinfo ( username, firstname, lastname, changeuserinfo, enableportallogin, creationdate, updatedate ) VALUES ( '$mac', '$resortid', '$rn',0 ,0, NOW(), NOW() )";


  if ($conn->query($sql1) === TRUE) {
    echo "";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }

  if ($conn->query($sql2) === TRUE) {
    echo "";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
    if ($conn->query($sql3) === TRUE) {
    echo "";
  } else {
    echo "Error: " . $sql . "<br>" . $conn->error;
  }
?>
