## Employee Management System
This Application is using Laravel, Materialize-css version 1.0.0 alpha-4 , material icons.

### Running this web application

```bash
  composer install
```


```bash
    cp .env.example .env
```

- generate application key.

```bash
    php artisan key:generate
```

- Add your database and mail driver credentials.

- create database tables.

```bash
    php artisan migrate
```

- create a default admin and genders.

```bash
    php artisan db:seed
```

- clear config (only if you make changes to .env file and restart the server if you are using laravel dev server).

```bash
    php artisan config:clear
```

- Link the storage folder for images.

```bash
    php artisan storage:link
```

- Start the development server.

```bash
    php artisan serve
```


#### Admin Credentials
- Email :- admin@admin.com
- Password :- Password

- Live demo link [Point Of Sales System link]()

Please star the project if you like it. Thank you!