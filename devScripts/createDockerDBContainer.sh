DB_PASSWORD=$(cat ../.env | head -n6 | tail -n 1 | cut -d '=' -f 2)
docker run --name platypusDb -p 3306:3306 -e MYSQL_ROOT_PASSWORD=$DB_PASSWORD -it mysql
