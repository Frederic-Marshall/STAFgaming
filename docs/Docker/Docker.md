# Docker

## Содержание

- [Содержание](#содержание)
- [Структура файлов docker](#структура-файлов-docker)
- [Запуск проекта](#запуск-проекта)
- [Описание контейнеров](#описание-контейнеров)
  - [`web` (Nginx)](#1-web-nginx)
  - [`php` (PHP-FPM + Laravel)](#2-php-php-fpm--laravel)
  - [`db` (PostgreSQL 15)](#3-db-postgresql-15)
  - [`vite` (Frontend Dev Server)](#4-vite-frontend-dev-server)
- [Работа с контейнерами](#работа-с-контейнерами)
    - [Запуск/остановка](#запускостановка)
    - [Логи](#логи)
    - [Подключение к контейнеру](#подключение-к-контейнеру)
    - [Обновление базы данных](#обновление-базы-данных)
    - [Запуск миграций](#запуск-миграций)
- [Очищение контейнеров и данных](#очищение-контейнеров-и-данных)
- [Дополнительно](#дополнительно)


## Структура файлов Docker

```
/docker
  ├── nginx/
  │   ├── nginx.conf
  ├── db/
  │   ├── dumps/
  │   │   ├── dumpfortest.sql
Dockerfile
docker-compose.yml
```

## Запуск проекта

1. Убедитесь, что у вас установлены **Docker** и **Docker Compose**.
2. В корне проекта выполните команду:
    ```sh
    docker-compose up
    ```
3. После успешного запуска доступность контейнеров можно проверить командой:
    ```sh
    docker ps
    ```

## Описание контейнеров

### 1. `web` (Nginx)

-   Использует `nginx:alpine`
-   Настроен через `docker/nginx/nginx.conf`
-   Проксирует запросы на PHP-FPM
-   Доступен на порту `8080`

### 2. `php` (PHP-FPM + Laravel)

-   Собирается из `Dockerfile`
-   Включает PHP 8.3 с необходимыми расширениями
-   Устанавливает зависимости Laravel через `composer install`
-   Работает в связке с `web` и `db`

### 3. `db` (PostgreSQL 15)

-   Образ `postgres:15`
-   Данные хранятся в volume `postgres_data`
-   Доступен на порту `5433`

### 4. `vite` (Frontend Dev Server)

-   Запускает `npm run watch`
-   Следит за изменениями в `frontend` и обновляет страницу автоматически
-   Доступен на порту `3000`

## Работа с контейнерами

### Запуск/остановка

-   Запустить контейнеры:
    ```sh
    docker-compose up
    ```
-   Остановить контейнеры:
    ```sh
    docker-compose down
    ```
-   Перезапустить контейнеры с пересборкой:
    ```sh
    docker-compose up -d --build
    ```

### Логи

-   Просмотреть логи контейнера:
    ```sh
    docker logs -f <container_name>
    ```
-   Например, для просмотра логов Laravel (PHP):
    ```sh
    docker logs -f php
    ```

### Подключение к контейнеру

-   Войти в контейнер PHP:
    ```sh
    docker exec -it php sh
    ```
-   Войти в контейнер базы данных:
    ```sh
    docker exec -it scatgaming-db-1 psql -U postgres -d scat
    ```

### Обновление базы данных

1. Добавить свежий дамп формата `.sql` в `docker/db/dumps/`.
2. Провести дамп Базы Данных

    ```sh
    docker exec -i scatgaming-db-1 psql -U postgres -d scat < docker/db/dumps/dumpfortest.sql
    ```

### Запуск миграций

```sh
docker compose exec php php artisan migrate
```

## Очищение контейнеров и данных

-   Удалить все контейнеры и тома:
    ```sh
        docker-compose down -v
    ```
-   Очистить ненужные образы и контейнеры:
    ```sh
        docker system prune -a
    ```

## Дополнительно

-   Настройки Laravel находятся в `.env.local`
-   Конфигурация Nginx в `docker/nginx/nginx.conf`
-   Доп. документация находится в `docs`
