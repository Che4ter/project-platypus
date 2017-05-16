# Project-Platypus

Back-End REST-API written in PHP using the Slim-Framework.

# API Documentation

***(work in progress)***

General API URL: `platypus.stair.ch/api/`

| Type | Description |
|------|--------------|
| `GET` | Used for retrieving resources. |
| `POST` | Used for creating resources. |
| `DELETE` | Used for deleting resources. |

## User

### GET

- all user: `/user`
- user by id: `/user/<id>`

### POST

- new user: `/user

## Feedback

### GET

- all feedback: `/feedback`
- feedback by ID: `/feedback/<id>`
- feedback by user ID: `/feedback/?user_id=<id>`
- feedback by hashtag: `/feedback/?hashtag[]=<hashtag1>&hashtag[]=<hashtag2>`

### POST

- new feedback: `/feedback` 

## Hashtag

### GET

- all hashtag: `/hashtag`

# Development

## PHP Development Web-Server

### Dependencies

#### php-cli
You need to install the package to run php as a command line tool. In most distros this package is called `php-cli`. 
#### composer

Visit [getcomposer.org](https://getcomposer.org/) and install composer. There may also be a package available for your distribution.

You can also just download the `composer.phar` file and run `php composer.phar` instead of `composer`. This way you don't need to install anything.

If you've installed composer run one of the following commands (depending on how you've installed composer):

```
composer install
php composer.phar install
```

This will download an install the projects PHP dependencies into the `./vendor/` directory.

### Running the Development Web Server

You can either run the Development Web-Server through composer or by using the `./serve.sh` script.

```
./serve.sh
composer run start
```

In the past the version with the script was more reliable because composer has an internal timeout and the server may get killed after 3 minutes.

## Database

Move the `.env.example` to `.env` and set up your database correctly.
Only MySQL is supported as of now (because of the SQL script to import the database, eloquent would support other databases as well).

Use the `devScripts/updateDb.sh` script to bring your database to the newest state.  
**Warning**: This script will delete your old data and SHOULD NOT be run in production environments.

Use this if if you want to initialise the database:

    devScripts/updateDb.sh --renew --seed

**Warning**: `--renew` will *drop the database* you defined in `.env`.
Run it without the renew if you want to set the permissions and create the database yourself.

Use the `--docker` option to use the mysqlclient inside a docker container.

## Unit-Tests

PHPUnit is used as the testing framework. Use either of the following commands to run the tests:

    phpunit # uses phpunit provided by the system
    vendor/bin/phpunit # used phpunit provided by composer
    composer run test # call phpunit through composer

the testsin tests/Functional use a testing database which can be configured in `.testenv`.

To initialise the test database used by the phpunit tests use the following command:

    devScripts/updateDb.sh --renew --seed --test

### Developer Info

## How to setup your system

1. create database: mysql -u root -p < ./db/db.sql
2. add dummy data to your db: mysql -u platypus -p platypusDb < ./db/dummy_data_import.sql
3. make sure you have to have JWT_SECRET AND JWT_TOKEN in your .env file
4. run ./devScripts/registerUser.sh
5. run ./devScripts/getToken.sh
6. try to make a GET request on localhost:8080/api/v1/user with Header "Authorization" "Bearer %YourToken%" (you find your token under /tmp/project-platypus-token"

### issues

mysql -h hostname -u username -p password databasename

If you have isues to connect via myslq, you may need to grant access. There is an example in ./db/db.sql

you may copy it via docker cp ./db/db.sql platypusDb:/tmp
