# Mikrotik PPPoE Client BW Utilization Graph

Requirements:
=============
* Only workable on Linux machine. (Tested on Docker LAMP, Ubuntu 18.04, Ubuntu 20.04)
* Apache 2.2/2.2+
* Need to install SNMP: <br><code><b>For Ubuntu -></b> apt install snmp</code> <br>OR <br><code><b>For Docker LAMP -></b> docker exec -t -i <i>container_id</i> apt install snmp</code>

Installation:
==============
* Just paste it on web directory.
* WEB Server/Apache must have shell script execution permission.

Integration With Mikrotik:
==========================
* From Mikrotik enable SNMP and set community string:
<br><code>snmp set enabled=yes</code>
<br><code>snmp community add name=mystring</code>
* Test netwrok reachability from Mikrotik to Web Server.
* From web server CLI test SNMP:
<br><code>snmpwalk -v 2c -c <i>snmp_community_string_here</i> -O e <i>mikrotik_ip_here</i> .1.3.6.1.2.1.1.1.0</code>
<br>Sample Output: <samp>iso.3.6.1.2.1.1.1.0 = STRING: "RouterOS CCR1036-8G-2S+"</samp>

BW Graph From WEB:
==================
![image](https://user-images.githubusercontent.com/19163763/214226591-1272421b-fca8-4a73-ad0b-cc63b3256d8b.png)
