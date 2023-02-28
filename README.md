# API for Users & Groups
An Application, developed using Laravel Framework

## Main Code Folders

| Folder | Description |
| --- | --- |
| [app/Http/Controllers/Api](https://github.com/Dima-RND-Tech/users/tree/main/app/Http/Controllers/Api) | API Controllers | 
| [app/Providers](https://github.com/Dima-RND-Tech/users/tree/main/app/Providers) | Provider Classes |
| [app/Services](https://github.com/Dima-RND-Tech/users/tree/main/app/Services) | Service Classes | 
| [tests/Feature](https://github.com/Dima-RND-Tech/users/tree/main/tests/Feature) | Feature Tests | 

## Minimum Requirements
- PHP 8.2
- Composer
- Docker

## Installation

Clone this repository
```
git clone git@github.com:Dima-RND-Tech/users.git
```

Install composer dependencies
```
cd users

composer install
```

Setup the project
```
cp .env.example .env

./vendor/bin/sail up -d

./vendor/bin/sail artisan key:generate
```

Run tests
```
./vendor/bin/sail artisan test
```

## Notes

- Using GitHub Actions, I configured [CI Scenario](https://github.com/Dima-RND-Tech/users/actions) for bulding the project, running Psalm analysis and unit testing before code reviews. 
