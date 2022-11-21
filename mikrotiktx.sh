#!/bin/bash

#NAS IP Taken From CLI
nasip=$1

#SNMP Community String Taken From CLI
snmpstr=$2

#Client SNMP ID
id=$3

#TX
tx=$(snmpwalk -v 2c -c $snmpstr -O e $nasip .1.3.6.1.2.1.31.1.1.1.10.$id | cut -d ':' -f 2 | xargs 2> /dev/null)

if [[ "$tx" =~ ^[0-9]+$ ]]
  then
    echo $tx
  else
    echo "NA"
fi