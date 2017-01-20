#!/bin/sh  

TOKEN_FILE=/tmp/project-platypus-token

# pretty print the output of the curl command using jq
ppcurl() {
    curl "$@" | jq .
}

curlauth() {
    curl -H "Authorization: Bearer $(cat "$TOKEN_FILE")" "$@"
}

ppcurlauth() {
    curlauth "$@" | jq .
}

save_token() {
    jq --raw-output .token > "$TOKEN_FILE"
}
