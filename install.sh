#!/bin/bash
# Download and install necessary components and files for this web site.
# Tested on Ubuntu 12.04.

base_path=$(readlink -f $(dirname $BASH_SOURCE))
temp_path=$base_path/.temp
if [ ! -d "$temp_path" ]; then
    mkdir "$temp_path"
fi

wget 'http://software77.net/geo-ip/?DL=2&x=Download' -O $temp_path/ip.zip
unzip -o -d $temp_path $temp_path/ip.zip
rm $temp_path/ip.zip

wget 'http://download.geonames.org/export/dump/cities1000.zip' -O $temp_path/cities.zip
unzip -o -d $temp_path $temp_path/cities.zip
rm $temp_path/cities.zip

