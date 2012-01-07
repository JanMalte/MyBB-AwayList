#!/bin/sh

#echo "Starting Virtual Screen"
#Xvfb :8 -ac &     # launch virtual framebuffer into the background
#PID_XVFB="$!"      # take the process ID
#export DISPLAY=:8  # set display to use that of the xvfb
#sleep 3

echo "Starting Selenium Server"
java -jar ./tests-selenium/selenium-server-standalone.jar -browserSideLog -ensureCleanSession -port 6666 >> sele.log 2>> sele.log &

sleep 5