#!/bin/bash

#NAS IP Taken From CLI
nasip=$1

#SNMP Community String Taken From CLI
snmpstr=$2

#Client SNMP ID
id=$3

#RX
rx=$(snmpwalk -v 2c -c $snmpstr -O e $nasip .1.3.6.1.2.1.31.1.1.1.6.$id | cut -d ':' -f 2 | xargs 2> /dev/null)

if [[ "$rx" =~ ^[0-9]+$ ]]
  then
    echo $rx
  else
    echo "NA"
fi