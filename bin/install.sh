#!/usr/bin/env bash

# init
#sudo apt-get update
#sudo apt-get dist-upgrade

# php
#sudo apt-get install php5 php5-cli mysql-server php5-dev php-pear php5-mysql php5-mcrypt libpcre3-dev
#sudo pecl install xdebug
sudo cat $HOME/bin/config/php/apache/php.ini | sudo tee /etc/php5/apache2/php.ini
sudo cat $HOME/bin/config/php/cli/php.ini | sudo tee /etc/php5/cli/php.ini


# composer
#curl -sS https://getcomposer.org/installer | php
#sudo mv composer.phar /usr/local/bin/composer

# apache
#sudo cat $HOME/bin/config/apache/000-default.conf | sudo tee /etc/apache2/sites-available/000-default.conf
#sudo service apache2 reload
#sudo a2enmod rewrite
#sudo service apache2 restart

# git
#sudo apt-get install git

# node
#cd $HOME/html
#curl -L git.io/nodebrew | perl - setup
#echo 'RUN THE FOLLOWING COMMAND FROM TERMINAL; LOGOUT AND BACK IN IF NECESSARY:'
#echo "echo 'PATH=$HOME/.nodebrew/current/bin:$PATH' >> .bashrc"
#cd $HOME/html
#nodebrew install-binary stable
#nodebrew use stable
#node -v
#cd $HOME/html
#npm install -g bower