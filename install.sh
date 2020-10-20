#!/bin/bash

#as each of these steps are completed, 
# you can simply delete the coresponding line from this 
#  file to resume where there may have been an error

source configure.sh

source dependencies.sh

cd $workingdir
source apache.sh

cd $workingdir
source httpdconf.sh

cd $workingdir
source conf.sh

cd $workingdir
source mysql.sh

php createtables.php

cd $workingdir
source virtualhost.sh

cd $workingdir
source html.sh

cd $workingdir
source certbot.sh

cd $workingdir
source composer.sh

cd $workingdir
source phpMyAdmin.sh



#/var/www/secrets/conf.php may still need some configuring
echo '/var/www/secrets/conf.php may still need some configuring'


exit
