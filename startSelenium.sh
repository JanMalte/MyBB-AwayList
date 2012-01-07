#!/bin/sh

#echo "Starting Virtual Screen"
#Xvfb :8 -ac &     # launch virtual framebuffer into the background
#export DISPLAY=:8  # set display to use that of the xvfb
#sleep 3

echo "Starting Selenium Server"
env DISPLAY=:8 java -jar ./tests-selenium/selenium-server-standalone.jar -debug -browserSideLog -ensureCleanSession -port 6666 >> sele.log 2>> build/logs/selenium_server.log &

sleep 20