#!/bin/bash

source configure.sh

sudo touch /etc/httpd/conf.d/${suffix}.conf

sudo chown ec2-user /etc/httpd/conf.d/${suffix}.conf

#Apache listen port should be left at 80

echo "

<VirtualHost *:80>
    ServerName ${suffix}
    ServerAlias www.${suffix}
    DocumentRoot /var/www/html
    ErrorLog /var/www/error.log
    CustomLog /var/www/requests.log combined
</VirtualHost>
" >> /etc/httpd/conf.d/${suffix}.conf 

sudo service httpd restart

