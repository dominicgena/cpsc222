--- PREPARATION ---
 Run the following in project root:
  Install curl: `sudo apt install curl`
  Run `chmod +x ./*.sh` to make shell scripts executable 

--- LAUNCH SERVER ---
 In project root, run `./run.sh`
 This shell script activates the venv if not already active, verifies flask installation, then starts the server

--- METHOD CLI ACCESS ---
Run
 `./users.sh <username> <password>` OR `./groups.sh <username> <password>`
 Explanation of shell scripts:
   Below: curl lets you view webpage contents from in terminal. -s tells output to be silent of unnecessary output,
   -o specifies where to map the output of this command to. By mapping it to /dev/null, we tell the output to go
   nowhere because it isn't necessary for logging in.
   `curl -s -o /dev/null "127.0.0.1:3000/api/users"`
   
   Below: -L tells curl how to handle redirects. username=$1&password=$2 specifies the password to be sent to
   the login form using the -d option. sed ... | sed ... formats output to only show things between pre tags,
   so we only see desired output rather than a full html page. The | (pipe) sends the standard output (stdout)
   from the first sed command as input for the second sed command to chain them.
   `curl -s -L -d "username=$1&password=$2" "127.0.0.1:3000/api" | sed -n '/<pre>/,/<\/pre>/p' |` 
    sed -e 's/<[^>]*>//g'`

--- SET UP RUN ON STARTUP ---
Run from in project directory:
 `mv usrgrprunsrv.service /etc/systemd/system/usrgrprunsrv.service`
 `sudo systemctl daemon-reload`
 `sudo systemctl enable usrgrprunsrv.service`
 [Test service]
 `sudo systemctl start myscript.service`
 `sudo systemctl status myscript.service`
 [View logs if needed]
 journalctl -u myscript.service
 Reboot and confirm it runs automatically
