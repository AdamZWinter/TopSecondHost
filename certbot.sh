#!/bin/bash

echo '############################################ starting Certbot.sh #####################################################################'

cd $workingdir/downloads
wget https://dl.eff.org/certbot-auto
chmod a+x certbot-auto
sudo ./certbot-auto --apache --debug

sudo mv /etc/httpd/conf.d/ssl.conf /etc/httpd/conf.d/zzzz-ssl.conf

sudo service httpd restart
sudo ls -l /etc/httpd/conf.d/


echo '############################################ end Certbot.sh  #########################################################################'

