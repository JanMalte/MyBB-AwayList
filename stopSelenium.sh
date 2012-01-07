#!/bin/sh
sleep 2

echo "Stopping Selenium"
ps -ef | grep -v grep | grep selenium | awk {'print $2'} | xargs kill; sleep 2

#echo "Stopping Virtual Screen"
#ps -ef | grep -v grep | grep Xvfb | awk {'print $2'} | xargs kill; sleep 2
