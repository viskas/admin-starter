# Laravel admin starter based on SB Admin 2

## Requirements

- PHP >= 7.3.0
- BCMath PHP Extension
- Ctype PHP Extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- ZIP Extension

## Installation

- Clone the repo and `cd` into it
- Run `composer install`
- Rename or copy `.env.example` file to `.env`
- Run `php artisan key:generate`
- Set your database credentials in your `.env` file
- Run migration `php artisan migrate --seed`

## Admin Credentials

Login: `admin@demo.com` <br>
Password: `adminadmin1A`

## Note

Recommend to install this preset on a project that you are starting from scratch, otherwise your project's design might break.

## License

Licensed under the MIT license.
