#!/bin/sh
dir=$(dirname $0)
. "$dir/curllib.sh"

tokendata="$(ppcurl --data "@$dir/postData/user.txt" localhost:8080/api/v1/auth/token)"
echo "$tokendata"
echo "Saving token to $TOKEN_FILE ..."
echo "$tokendata" | save_token
