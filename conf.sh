#!/bin/bash

echo '######################################## STARTING CONF.SH ###############################################################################'

source configure.sh

sudo touch /var/www/secrets/conf.php
sudo chown ec2-user:apache /var/www/secrets/conf.php
sudo chmod 660 /var/www/secrets/conf.php
cat ${workingdir}/conf.php > /var/www/secrets/conf.php

sudo sed -i "s/https:\/\/topsecondhost.com/https:\/\/${suffix}/g" /var/www/secrets/conf.php

sudo sed -i "s/topsecondhostdb/${database}/g" /var/www/secrets/conf.php

sudo sed -i "s/topsecondhostuser/${dbuser}/g" /var/www/secrets/conf.php

sudo sed -i "s/replacethisuniquestringuserpw/${dbpw}/g" /var/www/secrets/conf.php

sudo sed -i "s/TopSecondHost.com/${suffix}/g" /var/www/secrets/conf.php

sudo sed -i "s/noreply@topsecondhost.com/noreply@${suffix}/g" /var/www/secrets/conf.php


echo '############################### END CONF.SH ######################################################################################'
