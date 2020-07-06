#!/bin/sh


a2enconf zz-custom-security
a2enmod headers rewrite setenvif
du -hs . && rm -rf .git var/cache/* var/log/* vendor
ls -l && apt-get update && apt-get install -y gnupg2 apt-transport-https
curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add -
echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list
apt-get update && apt-get install -y wget mariadb-client nodejs npm yarn \
    libzip4 libzip-dev
docker-php-ext-configure zip --with-zip
docker-php-ext-install pdo_mysql intl zip

test ! -f composer.phar && wget https://github.com/composer/composer/releases/latest/download/composer.phar
php composer.phar self-update --1
php composer.phar install --no-scripts --no-dev -o --no-progress --no-suggest --prefer-dist
rm composer.phar

php bin/console assets:install
yarn install
yarn encore prod
rm -rf node_modules var/cache/* var/log/* /usr/local/share/.cache /root/.composer
chown -R 33:33 var

rm -rf node_modules

apt-get remove -y nodejs yarn npm
apt-get autoremove -y && apt-get clean -y
