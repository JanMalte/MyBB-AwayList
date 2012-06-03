#!/bin/sh

## uncomment the following lines to start a virtual xserver
#echo "Starting Virtual Screen"
#Xvfb :8 -ac &     # launch virtual framebuffer into the background
#export DISPLAY=:8  # set display to use that of the xvfb
#sleep 3

## start the selenium server
echo "Starting Selenium Server"
#env DISPLAY=:8 java -jar ./build-tools/selenium-server-standalone.jar -debug -browserSideLog -ensureCleanSession -port 6666 >> build/logs/selenium_server.log 2>> build/logs/selenium_server.log &
java -jar ./build-tools/selenium-server-standalone.jar -debug -browserSideLog -ensureCleanSession -port 6666 >> build/logs/selenium_server.log 2>> build/logs/selenium_server.log &
#java -jar ./build-tools/selenium-server-standalone.jar -debug -browserSideLog -ensureCleanSession -port 6666 >> build/logs/selenium_server.log 2>> build/logs/selenium_server.log &

## wait 5 seconds to make sure the selenium server is running
#sleep 5