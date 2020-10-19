#!/bin/bash

#as each of these steps are completed, 
# you can simply delete the coresponding line from this 
#  file to resume where there may have been an error
#   Of course, leave configure.sh at the top

source configure.sh

source dependencies.sh

source apache.sh

source httpdconf.sh

source mysql.sh

php createtables.php

source phpMyAdmin.sh

source virtualhost.sh

source certbot.sh

source composer.sh

#/var/www/secrets/conf.php may still need some configuring
echo '/var/www/secrets/conf.php may still need some configuring'


exit
