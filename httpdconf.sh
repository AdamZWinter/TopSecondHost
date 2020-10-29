#!/bin/bash

echo '#####################################################  starting httpdconf.sh #############################################################'

source configure.sh

sudo chown ec2-user /etc/httpd/conf/httpd.conf

sudo sed -i "s/#ServerName www.example.com:80/ServerName $suffix:443/g" /etc/httpd/conf/httpd.conf

sudo sed -i 's/ErrorLog "logs/error_log"/ErrorLog "/var/www/httpd_error.log"/g' /etc/httpd/conf/httpd.conf

sudo sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks/g' /etc/httpd/conf/httpd.conf

sudo sed -i '/<Directory "\/var\/www\/html">/a RewriteEngine on\nRewriteRule "^(\w+)$" "$1.php"' /etc/httpd/conf/httpd.conf

cat httpd.conf >> /etc/httpd/conf/httpd.conf

#ADD FilesMatch to not serve your secrets / configuration files

#Increase the MAX upload size in php.ini
#default reads "upload_max_filesize = 2M"
sudo sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 999M/g' /etc/php.ini

sudo chown root /etc/httpd/conf/httpd.conf

sudo service httpd restart


echo '#########################################################  end httpdconf.sh ################################################################'
