#!/bin/bash

	#for wordpress graphics processing only
	#sudo yum install php70-gd

sudo mkdir /var/www/revision
sudo mkdir /var/www/secrets

sudo chown ec2-user /etc/my.cnf
echo '
#The following was added to keep MySQL running with enough memory for innodb:
#This amount of memory could be even smaller if the memory problem exists
innodb_buffer_pool_size = 64M' >> /etc/my.cnf
sudo chown root /etc/my.cnf

sudo service httpd start
sudo service mysqld start

chkconfig --add httpd
chkconfig --add mysqld
sudo chkconfig httpd on
sudo chkconfig mysqld on
chkconfig --list httpd
chkconfig --list mysqld

sudo usermod -a -G apache ec2-user
sudo chown -R ec2-user:apache /var/www
sudo chmod 2775 /var/www
find /var/www -type d -exec sudo chmod 2775 {} \;
find /var/www -type f -exec sudo chmod 0664 {} \;

sudo yum install -y mod24_ssl

sudo touch /var/www/html/phpinfo.php
sudo chown ec2-user:apache /var/www/html/phpinfo.php
echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php

echo 'Check your Apache installation at your public IP address, also with /phpinfo.php'

read  -n 1 -p "Is everything good there / Continue? ( press: y or n ):" inputnext
if [ "$inputnext" = "y" ]; then
        echo Continuing
else
	echo 'Once you have figured out what went wrong, you can pick up where you left off by running each of .sh files in the order shown in install.sh after you source configure.sh'
        exit
fi

rm /var/www/html/phpinfo.php
