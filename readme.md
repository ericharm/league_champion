This is currently a base Laravel project with basic user auth and tests for Laravel's native Auth controllers

$ `git clone https://github.com/ericharm/league_champion`

$ `cd league_champion`

- create a database and a test database

- set up your database in .env

- set up your test database in .env.testing

$ `php artisan migrate --seed`

$ `phpunit`

$ `open report/index.html`
