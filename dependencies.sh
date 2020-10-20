#!/bin/bash

echo '############################################# starting dependencies.sh ##################################################################'

sudo yum update -y
        #sudo yum -y install epel-release
sudo yum install https://dl.fedoraproject.org/pub/epel/epel-release-latest-7.noarch.rpm -y
sudo yum-config-manager --enable epel

sudo fallocate -l 1G /swapfile
sudo chmod 600 /swapfile
sudo mkswap /swapfile
sudo swapon /swapfile

sudo yum install gcc -y
sudo yum install libxml2-devel -y

mkdir downloads
cd downloads

	#wget https://www.php.net/distributions/php-7.3.22.tar.gz
	#tar -xzf php-7.3.22.tar.gz
	#cd php-7.3.22
	#./configure
	#make
	#make test
	#sudo make install
	#php -v

sudo yum install -y httpd24 php73 mysql56-server php73-mysqlnd

read  -n 1 -p "Continue (press y or n):" inputnext
if [ "$inputnext" = "y" ]; then
        echo Now we will continue
else
        echo You did not press y
fi

sudo ldconfig -v



echo '################################################## end dependencies.sh ##############################################################'
