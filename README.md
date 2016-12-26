# API Documentation

***(work in progress)***

General API URL: `platypus.stair.ch/api/`

| Type | Description |
|------|--------------|
| `GET` | Used for retrieving resources. |
| `POST` | Used for creating resources. |
| `DELETE` | Used for deleting resources. |

## Users

### GET

- all users: `/users`
- user by id: `/users/id/<id>`

### POST

- new user: `/users/<id>/<password>/<role>`

## Comments

### GET

- all comments: `/comments`
- comment by ID: `/comments/id/<id>`
- comments by user: `/comments/user/<user_id>`
- comments by hashtag: `/comments/hashtag/<hashtag>`

### POST

- new comment: `/comments/…` ?

## Hashtags

### GET

- all hashtags: `/hashtags`
- hashtags by type: `/hashtags/type/<type_id>`

