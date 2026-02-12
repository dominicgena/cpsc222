#!/bin/sh
# -o /dev/null means direct output to /dev/null, effectively discarding it because
# output is not needed at the login stage
curl -k -s -o /dev/null "https://192.168.0.115/api/users"
curl -k -s -L -d "username=$1&password=$2" "https://192.168.0.115/api" | sed -n '/<pre>/,/<\/pre>/p' | sed -e 's/<[^>]*>//g'
