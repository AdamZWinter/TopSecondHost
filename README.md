# TopSecondHost  - Instructions

This is an automation script to quickly get an AWS Linux AMI working and configured (with SSL) LAMP stack (php).
After you have a working SES noreplay address, the basic site that is installed is ready for users to register and log in.

1)  Launch a new Amazon Linux AMI (not Linux 2), with ports 22, 80, and 443 open.  

2)  Configure DNS with A records for your domain, pointing at your new instance.

3)  SSH into your new instance, and run the following:

$ sudo yum install git-all

$ git clone https://github.com/AdamZWinter/TopSecondHost.git

$ cd TopSecondHost

$ vim configure.sh   (change values to match your domain, choose password etc...)
