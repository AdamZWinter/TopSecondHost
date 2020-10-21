#!/bin/bash

#Enter your domain name (suffix).  For example,  example.com  (without the host portion)
#You must have an A record set and propagated already.  Check at dnschecker.org
suffix='topsecondhost.com'

#Enter the username your site will use to access the database
#This is the service account used by the site to access the database
#This user name cannot be longer than 32 characters
#You can leave the default value here
dbuser='topsecondhost'

#Enter the database password that your site will use
#This is not the root password for the database
#This is the password for the database account that your site will use,
#it will have the minimal privileges needed
#For security purposes, this is not done programatically
#Use a very strong password.
#You must change this.
dbpw='putthepasswordhereinsidethesinglequotes'

#Enter a name for your site database
#For example, if your site is host.second.top, you could put "secondtop" or "second" here
database='topsecond'

#Enter your second-factor authentication generic password
#This should be a simple easy-2-enter password that is used like a pin
#This will be required to use the site self-editing capabilities
#You will have to enter this any time you edit the site code from the site itself
#You may choose to share this password with other people that you want to give code-editing access to
#So, do not make it something personal
#The hash of this password will be stored in the conf.php file
#Permission to the utilities will still have to be granted in the permissions table in addition to having this password
forhash='password'


workingdir=$(pwd)

