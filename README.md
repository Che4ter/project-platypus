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

## Database
***(only for testing)***
- import db.sql with 'mysql -u root -p -h localhost < db.sql'
- Username/Password: platypus


## How to install php / run the php server
install php-cli (php5-cli)
move composer.phar to project root
run "php composer.phar install" to copy all dependencies into ./vendor/

run "php composer.phar run start" to start the server
use localhost:8008 to access the website (/user for a first example)

run "php composer.phar run test" to run all tests

