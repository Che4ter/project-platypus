dir=$(dirname $0)

curl --data @$dir/userPostData.txt localhost:8080/api/v1/user
