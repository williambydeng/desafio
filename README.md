# Doutorie test project

## Getting started

This project were built with Laravel Sail 

### Setting up

Before start to run the container, select the database:

```bash
php artisan sail:install
```

In this case, I chose MySQL

#### Sail not found

If your receive this error: vendor/bin/sail no such file or directory
Run this:

```bash
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v $(pwd):/var/www/html \
    -w /var/www/html \
    laravelsail/php81-composer:latest \
    composer install --ignore-platform-reqs
```

### Running the project

In order to start docker run:

```bash
./vendor/bin/sail up
```

For more information, see the docs [here](https://laravel.com/docs/10.x/installation#getting-started-on-linux)


### Running commands in Sail

Now you'll need to run the migrations, in your app root folder run: 

```bash
./vendor/bin/sail php artisan migrate
```

Any php command you can run by adding ./vendor/bin/sail before

### Creating user

Send a POST request to /v1/auth in JSON format:

```bash
{
    "name": "admin",
    "password": "password",
    "email": "example@example.com"
}
```

### Getting the token

Send a POST request to /v1/auth/token in JSON format:

```bash
{
    "name": "admin",
    "password": "password",
}
```

