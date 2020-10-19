#!/bin/bash

	#for wordpress graphics processing only
	#sudo yum install php70-gd

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
sudo chmod 2775 /var/www
find /var/www -type d -exec sudo chmod 2775 {} \;
find /var/www -type f -exec sudo chmod 0664 {} \;

sudo yum install -y mod24_ssl

echo "<?php phpinfo(); ?>" > /var/www/html/phpinfo.php

echo 'Check your Apache installation at your public IP address, also with /phpinfo.php'

read  -n 1 -p "Is everything good there / Continue? ( press: y or n ):" inputnext
if [ "$inputnext" = "y" ]; then
        echo Continuing
else
        exit
fi

