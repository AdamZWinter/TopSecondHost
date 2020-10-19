#!/bin/bash

sudo chown ec2-user /etc/httpd/conf/httpd.conf

sudo sed -i 's/ErrorLog "logs/error_log"/ErrorLog "/var/www/httpd_error.log"/g' /etc/httpd/conf/httpd.conf

sudo sed -i 's/Options Indexes FollowSymLinks/Options FollowSymLinks/g' /etc/httpd/conf/httpd.conf

sudo sed -i '/<Directory "\/var\/www\/html">/a RewriteEngine on\nRewriteRule "^(\w+)$" "$1.php"' /etc/httpd/conf/httpd.conf

echo '#This was added to work with the small amount of RAM this system has and keep from thrashing
<IfModule prefork.c>
    StartServers            1
    MinSpareServers         1
    MaxSpareServers         8
    MaxConnectionsPerChild  8
    MaxRequestWorkers       32
</IfModule>

<Directory "/var/www/html/test">
    RewriteEngine on
    RewriteRule "^(\w+)$" "$1.php"
</Directory>

<Directory "/var/www/html/dashboard">
    RewriteEngine on
    RewriteRule "^(\w+)$" "$1.php"
</Directory>

<Directory "/var/www/html/dashboard/wizard">
    RewriteEngine on
    RewriteRule "^(\w+)$" "$1.php"
</Directory>

<FilesMatch "\.(php|html|htm)$">
   SetHandler application/x-httpd-php
</FilesMatch>
'  >> /etc/httpd/conf/httpd.conf

#ADD FilesMatch to not serve your secrets / configuration files

#Increase the MAX upload size in php.ini
#default reads "upload_max_filesize = 2M"
sudo sed -i 's/upload_max_filesize = 2M/upload_max_filesize = 999M/g' /etc/php.ini

sudo chown root /etc/httpd/conf/httpd.conf

sudo service httpd restart

