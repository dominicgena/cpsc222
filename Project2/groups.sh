#!/bin/sh
# -o /dev/null means direct output to /dev/null, effectively discarding it because
# output is not needed at the login stage
curl -s -o /dev/null "127.0.0.1:3000/api/groups"
curl -s -L -d "username=$1&password=$2" "127.0.0.1:3000/api" | sed -n '/<pre>/,/<\/pre>/p' | sed -e 's/<[^>]*>//g'
