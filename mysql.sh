#!/bin/bash

echo 'Starting mysql_secure_installation....'
sudo mysql_secure_installation

sudo chkconfig mysqld on

mkdir /var/www/secrets
cp ${workingdir}/conf.php /var/www/secrets/conf.php

sudo sed -i "s/https:\/\/hostsecondtop.com/https:\/\/${suffix}/g" /var/www/secrets/conf.php

sudo sed -i "s/secondtopdb/${database}/g" /var/www/secrets/conf.php

sudo sed -i "s/secondtopdbuser/${dbuser}/g" /var/www/secrets/conf.php

sudo sed -i "s/replacethisuniquestringuserpw/${dbpw}/g" /var/www/secrets/conf.php


echo Enter the root password for mysql below....
mysql -u root -p -e "CREATE USER '$dbuser'@'localhost' IDENTIFIED BY '$dbpw'; select User, Host, Password from mysql.user; CREATE DATABASE $database; SHOW DATABASES; GRANT SELECT, INSERT, UPDATE, DELETE, CREATE ON $database.* TO '$dbuser'@'localhost';"


exit

