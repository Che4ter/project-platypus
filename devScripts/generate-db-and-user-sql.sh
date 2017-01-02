#!/bin/bash

DBDIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
if [ "--test" = "$1" ]; then
    export $(cat "$DBDIR/../.testenv")
else
    export $(cat "$DBDIR/../.env")
fi

cat <<-CREATESQL
CREATE USER IF NOT EXISTS '$DB_USER'@'$DB_HOST' IDENTIFIED BY '$DB_PASSWORD';

DROP DATABASE IF EXISTS $DB_NAME;

CREATE DATABASE IF NOT EXISTS $DB_NAME;

USE $DB_NAME;

GRANT ALL ON $DB_NAME.* TO '$DB_USER'@'$DB_HOST';
CREATESQL
