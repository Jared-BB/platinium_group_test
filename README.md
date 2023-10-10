### Jared Barber Test for Platinium Group

## Installation

Hi! These are the steps to follow

1. Download the project from https://github.com/Jared-BB/platinium_group_test.git
2. init the docker with:
```
docker-compose up -d
```
3. once finished, you can enter in the docker with: 
```
docker exec -it platinium_group_php bash
```
4. Run the tests!
```
php bin/phpunit
```

### If Docker is not working on your machine, you can run the project the old way:
1. Download the project from https://github.com/Jared-BB/platinium_group_test.git
2. install all dependencies: 
```
composer install
```
3. Run the tests!
```
php bin/phpunit
```
4. Run tests with 100% of coverage: 
```
XDEBUG_MODE=coverage php bin/phpunit --coverage-text
```

### The exercise case it's covered on ProductTest.php

In the second case maybe you will need install some dependencies:
- install composer: https://getcomposer.org/download/
- instal PHP: https://utho.com/docs/tutorial/how-to-install-php-8-on-ubuntu-22-04/
- last dependency: sudo apt install php-xml
