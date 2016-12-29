#!/bin/sh

 dir=$(dirname $0)
mysqlpassword=$1
insertDummyData=$2

docker start platypusDb

mysql -u root -h 127.0.0.1 --password=$mysqlpassword < $dir/db.sql

if [ $insertDummyData ]
then
	mysql -u root -h 127.0.0.1 --password=$mysqlpassword < $dir/../devScripts/dummy_data_import.sql
fi

