#!/bin/bash


rm /var/www/secrets/conf.php
rm -d /var/www/secrets

read  -p "Enter the name of database to delete:" database
if [ -z "$database" ]; then
        echo You must enter something Not sure if you cant start this over without bad things.
        exit
elise
        echo you entered $database
fi

read  -p "Enter the user to delete:" dbuser
if [ -z "$dbuser" ]; then
        echo You must enter something Not sure if you cant start this over without bad things.
        exit
elise
        echo you entered $dbuser
fi



mysql -u root -p -e "DROP USER '$dbuser'@'localhost'; DROP DATABASE $database; SHOW DATABASES; select User, Host, Password from mysql.user;"


exit
