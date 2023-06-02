## Setup Database

- duplicate env.example and rename to .env
- set QUEUE_CONNECTION to database in .env
- update database information in .env
- create database 'queue_system'

## Setup codebase

- composer install
- npm install
- php artisan serve
- npm run dev
- php artisan queue:work

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
