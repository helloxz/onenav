#!/bin/sh
##########		name:Onenav容器运行入口			##########
##########		update:2021/03/22				##########
##########		author:xiaoz<xiaoz93@outlook.com>	######

onenav_path='/data/wwwroot/default'

# Check if favicon.ico exists, if not, copy it
if [ ! -f "$onenav_path/data/favicon.ico" ]; then
    cp "$onenav_path/favicon.ico" "$onenav_path/data/favicon.ico"
fi

#start php-fpm
php-fpm83 -RD
#start nginx
/usr/sbin/nginx
# 设置DNS
echo "nameserver 223.5.5.5" > /etc/resolv.conf
echo "nameserver 119.29.29.29" >> /etc/resolv.conf
tail -f /var/log/nginx/error.log
