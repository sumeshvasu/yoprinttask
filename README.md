### System Specifications

- PHP 8.2.0
- MySql 5.7

### Application Specifications

- Laravel 10

### Application Setup / Installation

- Clone project : Choose any of the option
  - SSH &ensp;- git clone git@github.com:sumeshvasu/yoprinttask.git
  - HTTP - git clone https://github.com/sumeshvasu/yoprinttask.git
- cd yoprinttask
- run : composer install
- run : php artisan migrate

- run in new console : redis-server
- run in new console : php artisan queue:listen --timeout=0
