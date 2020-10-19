#!/bin/sh

cd $workingdir
sudo mkdir composer
cd composer

EXPECTED_CHECKSUM="$(wget -q -O - https://composer.github.io/installer.sig)"
sudo php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]
then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

sudo php composer-setup.php --quiet --filename=composer --install-dir=/usr/local/bin
RESULT=$?
sudo rm composer-setup.php
exit $RESULT

cd /var/www
composer require phpmailer/phpmailer
