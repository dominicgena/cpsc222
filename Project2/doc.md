

build:
run (in project root):
 Update: `sudo apt update`
 Upgrade: `sudo apt upgrade`
 Install venv for dependency isolation: `sudo apt install python3-venv`
 Initialize the venv: `python3 -m venv venv`
 Activate the virtual environment: `source /venv/bin/activate`
 Install flask dependency for server: `pip install flask`
 `flask --version` to confirm installation
 Install curl: `sudo apt install curl` (Do this outside the venv)
 Start the server: `flask run` (from inside the venv)
 Inside or outside of the venv, in the project directory, run `chmox +x ./*.sh` to make shell scripts executable 
 To get user data, run ./users.sh. For groups, run ./groups.sh

 Method access shell script contents and explanation: `curl -s -d "username=test&password=abcABC123" http://127.0.0.1:5000/api && \curl -s http://127.0.0.1:5000/api/{METHOD} | tr -d '\n\r' | grep -oP '(?<=<h1>)[^<]+'`
  Explanation: curl returns webpage contents in terminal. -s tells it to be quiet, -d tells it which POST data to
   send, "username=...&password=..." represent the actual data to send. http://... is sign-in url that receives post 
   data. The command is then repeated but this time for the {METHOD} page, which would be users or groups.
   `tr -d '\n\r' | grep -oP '(?<=<h1>)[^<]+'` strips the page's contents to only contain the necessary data 
   tr deletes the returns from the html (there shouldn't be any, but just to be safe). grep... filters output to only
   show contents of h1 tags, which is where the data lives for the requested method.
