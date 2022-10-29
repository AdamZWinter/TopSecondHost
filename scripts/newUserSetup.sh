#!/bin/sh

useradd -m -s /bin/bash ${1}
usermod -aG html ${1}
cp -r /home/orangegr/.ssh /home/${1}/
chown ${1}:${1} -R /home/${1}/.ssh
echo '  ' >> /home/${1}/.bashrc
echo 'eval "$(ssh-agent -s)"' >> /home/${1}/.bashrc
echo "ssh-add /home/${1}/.ssh/githubAdam" >> /home/${1}/.bashrc
echo "cd /var/www/html/${1}" >> /home/${1}/.bashrc

mkdir /var/www/html/${1}
chown ${1}:${1} -R /var/www/html/${1}

passwd ${1}
