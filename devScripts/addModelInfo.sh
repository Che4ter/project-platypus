#!/usr/bin/env bash

# connects to the mysql database defined in .env
# and adds the result of an explain query on the table to the
# top of each model file in src/Model/*.php (replaces old query results)
# The model file must contain "/*DATABASE TABLE" and the "E DATABASE TABLE*/"
# lines to store the result of the explain query.

SCRIPTDIR=$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)
PROJECTDIR="$SCRIPTDIR/.."
DBDIR="$PROJECTDIR/db"
MODELDIR="$PROJECTDIR/src/Model"

env_file="$PROJECTDIR/.env"
echo "Loading database settings from $env_file"
export $(cat "$env_file" | xargs)

get_table_name_from_model_file() {
    local model_file="$1"
    local table_line="$(grep '\$table' "$model_file")"
    if [ -n "$table_line" ]; then
        sed -e 's/[^"'"'"']\+\(["'"'"']\)\([^"'"'"']\+\)\1;/\2/g' <<< "$table_line"
    else
        model_filename="$(basename "${model_file}")"
        tr '[:upper:]' '[:lower:]' <<< "${model_filename%.*}s"
    fi
}


mysql_command="mysql --table --user=$DB_USER --password=$DB_PASSWORD --host=$DB_HOST $DB_NAME"

for model_file in "$MODELDIR/"*".php"; do
    explain_query="$(get_table_name_from_model_file "$model_file" | sed 's/\(.\+\)/explain \1;/g')"
    tmp="$(mktemp)"
    {   sed -n '1,/\/*DATABASE TABLE/p' "$model_file"
        $mysql_command <<< "$explain_query"
        sed -n '/^E DATABASE TABLE/,$p' "$model_file"
    } > "$tmp"
    mv "$tmp" "$model_file"
done
