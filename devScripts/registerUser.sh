#!/bin/sh
dir=$(dirname $0)
. "$dir/curllib.sh"

ppcurl --data "@$dir/postData/user.txt" localhost:8080/api/v1/user
