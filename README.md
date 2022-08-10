# chromecast-data-feed
A DHCP based Chromecast data feed for O&amp;M on deployed Chromecasts


#PHP API URL(s)
**⚠ WARNING: **
(Don't run the sendinfo.php against production db then it might mess up the information)

#To see the live data:
http://172.16.88.17/api/chromecastWatcher/dashboard.php

#To get the room data:
http://172.16.88.17/api/chromecastWatcher/get_room_data.php?mac=08:9E:08:53:ED:F1

#To get the IP of the chromecast device by mac:
http://172.16.88.17/api/chromecastWatcher/get_chromecast_ip.php?mac=08:9E:08:53:ED:F1

#To send MK router data to API DB:
http://172.16.88.17/api/chromecastWatcher/sendinfo.php?hostname=Chromecast&activeMAC=08:9E:08:53:D9:6F&activeIP=172.16.80.19&serverName=dhcpGuest&type=ipbound

#To import all the hotel rooms by hotel code:
http://172.16.88.17/api/chromecastWatcher/sendinfo.php?type=reload_data&hotelcode=SPSF

