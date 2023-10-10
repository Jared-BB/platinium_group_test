# platinium_group_test
Test for Platinium Group

Maybe you need to install somethings to run the project:
install composer: https://getcomposer.org/download/
instal PHP: https://utho.com/docs/tutorial/how-to-install-php-8-on-ubuntu-22-04/
and this tool for linux: sudo apt install php-xml

Hi! Steps to follow

1. Download the project

2. Run: composer install

3. Run the tests!
php bin/phpunit

With 100% of coverage
XDEBUG_MODE=coverage php bin/phpunit --coverage-text

The execirse case its cover on ProductTest.php
