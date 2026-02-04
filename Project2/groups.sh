#!/bin/sh
curl -s -d "username=$1&password=$2" http://127.0.0.1:5000/api && \curl -s http://127.0.0.1:5000/api/groups | tr -d '\n\r' | grep -oP '(?<=<h1>)[^<]+'
