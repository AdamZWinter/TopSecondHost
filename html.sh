#!/bin/bash

echo '##########################################  Starting html.sh ####################################################'

source configure.sh

cd html
cp -R * /var/www/html

sudo sed -i "s/topsecondhost.com/${suffix}/g" /var/www/html/robots.txt

sudo sed -i "s/topsecondhost.com/${suffix}/g" /var/www/html/sitemap.xml

sudo sed -i "s/secondtopdbuser/${suffix}/g" /var/www/html/dashboard/menu.php


echo '############################################  End html.sh #############################################################'
