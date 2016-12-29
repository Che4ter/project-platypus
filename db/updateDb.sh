#!/bin/sh

mysqlpassword=$1
insertDummyData=$2

docker start platypusDb

docker exec -i platypusDb mysql -u root --password=$mysqlpassword < ./db/db.sql

if [ $insertDummyData ]
then
	docker exec -i platypusDb mysql -u root --password=$mysqlpassword <./db/dummy_data_import.sql
fi

