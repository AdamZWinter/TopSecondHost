#!/bin/bash

echo '################################### starting phpMyAdmin.sh #########################################################'

source configure.sh

cd /var/www/html

wget https://files.phpmyadmin.net/phpMyAdmin/4.9.5/phpMyAdmin-4.9.5-english.tar.gz
sleep 1
mkdir /var/www/html/phpMyAdmin
tar -xzf phpMyAdmin-4.9.5-english.tar.gz -C /var/www/html/phpMyAdmin --strip-components 1
sleep 1
rm phpMyAdmin-4.9.5-english.tar.gz

cd $workingdir


echo '############################################## end phpMyAdmin.sh ############################################################'
