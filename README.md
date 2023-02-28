# API for Users & Groups
An Application, developed using Laravel Framework

## Main Code Folders

| Folder | Description |
| --- | --- |
| [app/Http/Controllers/Api](https://github.com/Dima-RND-Tech/users/tree/main/app/Http/Controllers/Api) | API Controllers | 
| [app/Http/Resources](https://github.com/Dima-RND-Tech/users/tree/main/app/Http/Resources) | Resources Classes |
| [app/Models](https://github.com/Dima-RND-Tech/users/tree/main/app/Models) | Models Classes |
| [app/Interfaces](https://github.com/Dima-RND-Tech/users/tree/main/app/Interfaces) | Interfaces |
| [app/Providers](https://github.com/Dima-RND-Tech/users/tree/main/app/Providers) | Provider Classes |
| [app/Services](https://github.com/Dima-RND-Tech/users/tree/main/app/Services) | Service Classes | 
| [database/migrations](https://github.com/Dima-RND-Tech/users/tree/main/database/migrations) | Database Migrations | 
| [tests/Feature](https://github.com/Dima-RND-Tech/users/tree/main/tests/Feature) | Feature Tests | 
| [storage/api-docs/api-json.js](https://github.com/Dima-RND-Tech/users/tree/main/storage/api-docs/api-json.js) | OpenAPI Documentaion | 

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

./vendor/bin/sail migrate --seed
```

Run tests
```
./vendor/bin/sail artisan test
```

## Notes

- GitHub Actions [CI Scenario](https://github.com/Dima-RND-Tech/users/actions) for bulding the project, running Psalm analysis and unit testing before code reviews. 
