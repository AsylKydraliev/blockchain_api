# BlockchainApi

Разработан на <p><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="100" alt="Laravel Logo"></a></p>

Основные функциональные возможности проекта включают:

* Получение текущих курсов валют.
* Получение интересующих валют.
* Конвертация валют.

-----

## 🛠️ Установка

### Предварительные требования

* [PHP ^8.1](https://www.php.net/manual/ru/install.php)
* [Composer (v2+)](https://getcomposer.org/doc/00-intro.md)
* SQLite for local, MySQL or PostgreSQL for production

### Локальная установка

1. Склонируйте репозиторий проекта
```sh
git clone https://github.com/AsylKydraliev/blockchain_api.git
```

2. Перейдите в директорию проекта
```sh
cd blockchain_api
```

3. Скопируйте файл .env.example и переименуйте его в .env
```sh
cp .env.example .env
```

4. Укажите параметры подключения к БД в файле .env
```sh
DB_CONNECTION=sqlite
```

5. Установите зависимости, используя Composer
```sh
composer install
```

8. Сгенерируйте ключ приложения
```sh
php artisan key:generate
```

9. Примените миграции и заполнените данные сидерами
```sh
php artisan migrate --seed
```

10. Запустите локальный сервер разработки
```sh
php artisan serve --port=9876
```

-----

## 🖥️ Руководство тестирования

Для получения списка курса валют необходимо сделать GET запрос на:
* http://127.0.0.1:9876/api/v1/currencies

Для получения интересующих валют необходимо сделать GET запрос с параметрами на:
* http://127.0.0.1:9876/api/v1/currencies?currency=USD,RUB,EUR

Для запроса на обмен валюты необходимо сделать POST запрос на:
* http://127.0.0.1:9876/api/v1/currencies?currency_from=BTC&currency_to=USD&value=0.01
