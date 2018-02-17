#!/bin/bash

sed -i 's@try_files $uri $uri/ =404;@try_files $uri $uri/ /index.php$is_args$args;@g' /etc/nginx/sites-available/default.conf
