# User Management Application
- Developed using Laravel Framework.
- Provides API Endpoints according to the OpenAPI Specification.
- Contains GitHub Actions [CI Scenario](https://github.com/Dima-RND-Tech/users/actions) for bulding the project, running Psalm analysis and unit testing before code reviews. 

## Main Code Folders

| Folder | Description |
| --- | --- |
| [app/Interfaces](https://github.com/Dima-RND-Tech/users/tree/main/app/Interfaces) | Interfaces |
| [app/Services](https://github.com/Dima-RND-Tech/users/tree/main/app/Services) | Service Classes | 
| [app/Models](https://github.com/Dima-RND-Tech/users/tree/main/app/Models) | Model Classes |
| [app/Http/Resources](https://github.com/Dima-RND-Tech/users/tree/main/app/Http/Resources) | Resource Classes |
| [app/Providers](https://github.com/Dima-RND-Tech/users/tree/main/app/Providers) | Provider Classes |
| [app/Http/Controllers/Api](https://github.com/Dima-RND-Tech/users/tree/main/app/Http/Controllers/Api) | API Controllers | 
| [database/migrations](https://github.com/Dima-RND-Tech/users/tree/main/database/migrations) | Database Migrations | 
| [tests/Feature](https://github.com/Dima-RND-Tech/users/tree/main/tests/Feature) | Feature Tests | 
| [storage/api-docs/api-docs.json](https://github.com/Dima-RND-Tech/users/tree/main/storage/api-docs/api-docs.json) | OpenAPI Documentation | 

## Minimum Requirements
- PHP 8.1
- Composer
- Docker

## Diagrams & Screenshots

| Database Structure | Main Classes | 
| :---: | :---: |
| <img src="https://user-images.githubusercontent.com/110030000/221865173-1ed75ebd-cfb7-4b7f-b18e-3320dc7c646a.png" width="500" height="320"> | <img src="https://user-images.githubusercontent.com/110030000/221877234-32bdb44a-4916-4421-859f-c4c6b36b4d76.png" width="500" height="320"> |
| API Endpoints | Endpoint users/create |
| <img src="https://user-images.githubusercontent.com/110030000/221867340-72cc91b9-87d4-40c5-a356-e5f787075b46.png" width="500" height="320"> | <img src="https://user-images.githubusercontent.com/110030000/221867345-5d57cf7a-5d1c-41d5-93c3-6787892c0e47.png" width="500" height="320"> |
|  API Schemas | Endpoint users/delete | 
| <img src="https://user-images.githubusercontent.com/110030000/221867342-3a800dd1-82dd-4d86-ba0f-51e16bd11e08.png" width="500" height="310"> |  <img src="https://user-images.githubusercontent.com/110030000/221867348-d18af210-42b9-4700-831c-9659c401e149.png" width="500" height="310"> |

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

./vendor/bin/sail artisan migrate --seed
```

Run tests
```
./vendor/bin/sail artisan test
```

## Browsing & Using the API Endpoints

Open in browser:

[http://project.local/api/documentation/](http://project.local/api/documentation/)

Default API Key for checking Endpoints:
```
$2y$10$Sljvx5p3jAMMYpvJCbXi7OP/oIGctAqy83xKgMKpZDA1pOSWjHth.
```
