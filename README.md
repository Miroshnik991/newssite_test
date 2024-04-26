# laravel-starter.

## Introduction:

Laravel starter provides simple containerized infrastructure of `Laravel, Nginx, Mysql and Xdebug`.

## Getting started:

## local deployment:

### 1) create `.env` file in `app` directory (copy`.env-example`).
### 2) Start containers through:
#### `docker compose --env-file app/.env up -d`.
### 3) Into app container run next command:
#### `composer install`.
### 4) If you want, you may to rename container group and separate containers
To do this rename all using `your-project-name` into `docker-compose.yaml` file.
