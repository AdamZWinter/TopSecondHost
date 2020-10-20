#!/bin/bash

echo '######################################## STARTING MYSQL.SH ###############################################################################'

source configure.sh

echo 'Starting mysql_secure_installation....'
sudo mysql_secure_installation

sudo chkconfig mysqld on

echo Enter the root password for mysql below....
mysql -u root -p -e "CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpw'; select User, Host, Password from mysql.user; CREATE DATABASE $database; SHOW DATABASES; GRANT SELECT, INSERT, UPDATE, DELETE, CREATE ON $database.* TO '$dbuser'@'localhost';"


echo '############################### END MYSQL.SH ######################################################################################'
