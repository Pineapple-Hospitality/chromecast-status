# chromecast-data-feed
A DHCP based Chromecast data feed for O&amp;M on deployed Chromecasts


**PHP API URL(s)**<br />
**⚠ WARNING: **<br />
(Don't run the sendinfo.php against production db then it might mess up the information)

#To see the live data:<br />
http://172.16.88.17/api/chromecastStatus/dashboard.php

#To get the room data:<br />
http://172.16.88.17/api/chromecastStatus/get_room_data.php?mac=08:9E:08:53:ED:F1

#To get the IP of the chromecast device by mac:<br />
http://172.16.88.17/api/chromecastStatus/get_chromecast_ip.php?mac=08:9E:08:53:ED:F1

#To send MK router data to API DB:<br />
http://172.16.88.17/api/chromecastStatus/sendinfo.php?hostname=Chromecast&activeMAC=08:9E:08:53:D9:6F&activeIP=172.16.80.19&serverName=dhcpGuest&type=ipbound

#To import all the hotel rooms per hotel code from radius db:<br />
http://172.16.88.17/api/chromecastStatus/sendinfo.php?type=reload_data&hotelcode=SPSF

#To send chromecast eureka_info to API DB:<br />
http://172.16.88.17/api/chromecastStatus/sendinfo.php?eureka_info=$deviceDataOnlyEscaped&activeMAC=$leaseActMAC&type=devicedata&format=json" <br/>
where {$deviceDataOnlyEscaped} is url encoded eureka_info and {$leaseActMAC} is MK mac id variable<br/>

For future case(s), few parameter(s) have been added to handle different data request(s) for the sendinfo.php api file. For example:- <br/>
"type" like ipbound, devicedata, reload_data ... etc <br/>
"format" <br/>
... etc <br/>

