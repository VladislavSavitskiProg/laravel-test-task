<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Application

Test task

## Deploy step by step

    1. git clone https://github.com/vovakovalchukk/laravel-test-task.git
    2. cd laravel-test-task
    3. cp .env.example .env
    4. docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
    5. ./vendor/bin/sail up -d
    6. ./vendor/bin/sail composer install
    7. ./vendor/bin/sail artisan migrate:fresh --seed
    8. ./vendor/bin/sail artisan import:capacities-csv --file-path=imports/capacity.csv
    9. ./vendor/bin/sail artisan import:bookings-csv --file-path=imports/bookings.csv
    10. ./vendor/bin/sail artisan bookings:update-statuses
    11. ./vendor/bin/sail artisan statistic:generate
    12. ./vendor/bin/sail artisan key:generate

    That's all! Open your brouser: http://localhost/


ps. In addition, as more flexibility, reliability and extensibility, it is necessary to add a layer of task scheduler, queues, as well as logging.

The calculation may be incorrect, sufficient time was not given to testing, I really hope that the purpose of the test task was not this

I will happy to join your team :)

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
