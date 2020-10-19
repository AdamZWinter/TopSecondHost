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

workingdir=$(pwd)

