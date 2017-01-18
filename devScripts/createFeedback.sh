#!/bin/sh
dir=$(dirname $0)
source "$dir/curllib.sh"

ppcurlauth -v --data "@$dir/postData/feedback.txt" localhost:8080/api/v1/feedback
