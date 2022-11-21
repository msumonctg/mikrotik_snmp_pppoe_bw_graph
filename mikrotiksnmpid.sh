#!/bin/bash

#NAS IP Taken From CLI
nasip=$1

#SNMP Community String Taken From CLI
snmpstr=$2

#Client PPPoE ID
cid=$3

rtrpppinname="pppoe-$cid"

# SNMP ID
id=$(snmpwalk -v 2c -c $snmpstr -O e $nasip .1.3.6.1.2.1.31.1.1.1.1 | grep $rtrpppinname | cut -d '=' -f 1 | cut -d '.' -f 12 | xargs)

if [[ "$id" =~ ^[0-9]+$ ]]
  then
    echo $id
  else
    echo "NA"
fi