#!/bin/bash

cd $workingdir/downloads
wget https://dl.eff.org/certbot-auto
chmod a+x certbot-auto
sudo ./certbot-auto --apache --debug

sudo service httpd restart
sudo ls -l /etc/httpd/conf.d/

