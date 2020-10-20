# TopSecondHost  - Instructions

This is an automation script to quickly get an AWS Linux AMI working and configured (with SSL) LAMP stack (php).
After you have a working SES noreply address, the basic site that is installed is ready for users to register and log in.

1)  Launch a new Amazon Linux AMI (not Linux 2), with ports 22, 80, and 443 open.  

2)  Configure DNS with A records for your domain, pointing at your new instance.

    2A)  WAIT until the records have propagated.  Your Certbot certificate will fail if DNS fails.  Check at dnschecker.org

3)  SSH into your new instance, and run the following:

$ sudo yum install git-all

$ git clone https://github.com/AdamZWinter/TopSecondHost.git

$ cd TopSecondHost

$ vim configure.sh   (change values to match your domain, choose password etc...)

$ ./install.sh

At the following prompts:

y to coninue if everything looks like it installed correctly

Check your Apache installation at your public IP address, also with /phpinfo.php: 
In you browser, go to your website, you should find the Apache test page.  
Also, go to yourwebsite.com/phpinfo.php and you should find the php info page
y to continue from there

Enter current password for root (enter for none):
This is the secure installation for mysql, there is no root password yet.  So press enter for none.

Set root password? [Y/n]  Y
Choose a strong password here as anyone will be able to log into your database through phpMyAdmin, with root privileges, if you leave that enabled, or do not whitelist IP address.  It's strongly recommended that you do both.

Y to the next four prompts (Remove..., Disallow...., Remove..., Reload....)

Enter the root password for mysql below....  (Enter the root password that you just created a moment ago)

Enter email address (used for urgent renewal and security notices)
This is for certbot installation.  It's highly recommend that you do enter your email address here so that you receive notices when your SSL cert is about to expire.

Which names would you like to activate HTTPS for?
Press enter to select both.


When installation is finished, you should find the https site 
 

You can run each section of the installation by manually executing the same commands in install.sh (in the same order).

