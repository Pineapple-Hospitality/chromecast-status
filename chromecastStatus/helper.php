<?php
function response($status,$data,$status_message)
{
        header("HTTP/1.1 ".$status);
        $response['status']=$status;
        $response['status_message']=$status_message;
        $response['data']=$data;
        $json_response = json_encode($response);
        echo $json_response."\n";
}
?>
