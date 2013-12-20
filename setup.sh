#!/bin/bash

PHP_INI=/etc/php5/fpm/php.ini
sudo apt-get install php5-dev php-pear php5-curl libyaml-dev
sudo pecl install yaml

if [ ! -d lib ]; then
    mkdir lib
fi

cd lib
git clone --depth 1 https://github.com/imakewebthings/deck.js.git deck

