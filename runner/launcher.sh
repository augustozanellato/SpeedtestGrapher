#!/bin/sh
cp /usr/share/zoneinfo/$TZ /etc/localtime 
echo $TZ > /etc/timezone

cd /speedtest
#wait for mariadb to come up
./wait-for -t 60 db:3306

python speedtest_runner.py