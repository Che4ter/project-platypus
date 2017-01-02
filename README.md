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

### Development

## How to install php / run the php server
install php-cli (php5-cli)
move composer.phar to project root
run "php composer.phar install" to copy all dependencies into ./vendor/

run "php composer.phar run start" to start the server
use localhost:8080 to access the website (/api/v1/user for a first example)

run "php composer.phar run test" to run all tests

### Database

Move the `.env.example` to `.env` and set up your database correctly.
Only MySQL is supported as of now (because of the SQL script to import the database, eloquent would support other databases as well).

Use the `devScripts/updateDb.sh` script to bring your database to the newest state.  
**Warning**: This script will delete your old data and SHOULD NOT be run in production environments.

Use this if if you want to initialise the database:

    devScripts/updateDb.sh --renew --seed

**Warning**: `--renew` will *drop the database* you defined in `.env`.
Run it without the renew if you want to set the permissions and create the database yourself.

Use the `--docker` option to use the mysqlclient inside a docker container.

### Tests

PHPUnit is used as the testing framework. Use either of the following commands to run the tests:

    phpunit # uses phpunit provided by the system
    vendor/bin/phpunit # used phpunit provided by composer

the testsin tests/Functional use a testing database which can be configured in `.testenv`.

To initialise the test database used by the phpunit tests use the following command:

    devScripts/updateDb.sh --renew --seed --test
