#!/bin/sh
curl -s -d "username=test&password=abcABC123" http://127.0.0.1:5000/api && \curl -s http://127.0.0.1:5000/api/users | tr -d '\n\r' | grep -oP '(?<=<h1>)[^<]+'
