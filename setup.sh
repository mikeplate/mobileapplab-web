#!/bin/bash

PHP_INI=/etc/php5/fpm/php.ini
sudo apt-get install php5-dev php-pear php5-curl libyaml-dev
sudo pecl install yaml

if [ ! -d lib ]; then
    mkdir lib
fi

cd lib
if [ ! -d deck ]; then
    git clone --depth 1 https://github.com/imakewebthings/deck.js.git deck
else
    cd deck
    git pull
    cd ..
fi
if [ ! -d reveal ]; then
    git clone --depth 1 https://github.com/hakimel/reveal.js.git reveal
else
    cd reveal
    git pull
    cd ..
fi

