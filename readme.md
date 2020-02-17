
## Installation Instructions

### Install Composer if dont' have already installed
    - Run `apt install composer`

- Run `composer install`
- Run `cp .env.example .env`
- Run `php artisan key:generate`
- Set your app configration to .env
- Run `php artisan route:clear` 
- Run `php artisan config:clear` 
- Run `php artisan migrate`
- Run `php artisan db:seed`





## Test your application
- run `vendor/bin/phpunit`

# Enjoy
