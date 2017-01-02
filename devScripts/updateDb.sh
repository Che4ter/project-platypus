#!/bin/bash

# abort if any of this fails
set -b

SCRIPTDIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
PROJECTDIR="$SCRIPTDIR/.."
DBDIR="$PROJECTDIR/db"

docker_name=
mysql_command_prefix=
usetest=0
env_file=.env
seed=0
renew=0

while [ $# -gt 0 ]; do
   case "$1" in
       --docker)
       shift
           dockername="$1"
           mysql_command_prefix=docker exec -i "$dockername"
       ;; 
       --seed)
          seed=1 
       ;;
       --test)
          usetest=1
          env_file=.testenv
       ;;
       --renew)
          renew=1
       ;;
       --help)
           echo "usage $0 [--docker containername] [--seed] [--test] [--renew]"
           echo "Reinitializes/updates the tables in database defined in .env or .testenv"
           echo "WARNING: You will loose your data!!!!!!"
           echo ""
           echo " --docker containername     use the given docker container"
           echo "                            to host the database"
           echo " --seed                     seed the database with some dummy data"
           echo " --test                     use the test database instead of the"
           echo "a                           database defined in .env"
           echo " --renew                    drop the database first"
           exit 1;
       ;;
   esac
   shift
done

echo "Loading database settings from $DBDIR/../$env_file"
export $(cat "$DBDIR/../$env_file")

mysql_command="$mysql_command_prefix mysql --user=$DB_USER --password=$DB_PASSWORD --host=$DB_HOST $DB_NAME"


if [ -n "$dockername" ]; then
    docker start "$dockername"
fi

if [ "$renew" -eq 1 ]; then
    echo "Recreating database users ... "
    dbgenerator_conn=
    if [ "$usetest" -eq 1 ]; then
        dbgenerator_conn="--test"
    fi
    root_mysql_command=
    echo "Using '$mysql_command_prefix mysql -u -p --host=$DB_HOST' to connect to the database"
    "$SCRIPTDIR/generate-db-and-user-sql.sh" $dbgenerator_conn | \
        $mysql_command_prefix mysql -uroot -p --host=$DB_HOST
    if [ "$?" -ne 0 ]; then
        echo "Abort. Login Failed."
        exit 2
    fi
        
fi

echo "Using '$mysql_command' to connect to the database"

echo "Importing $DBDIR/db.sql"
$mysql_command < "$DBDIR/db.sql"

if [ "$seed" -eq 1 ]; then
    echo "Seeding database with $DBDIR/dummy_data_import.sql";
	$mysql_command < "$DBDIR/dummy_data_import.sql"
fi

