#!/usr/bin/env bash

# Install composer dependencies
composer install

mysql -e 'CREATE DATABASE IF NOT EXISTS test;'

php tests/app/yii migrate --interactive=0
php tests/app/yii fixture/load * --interactive=0
