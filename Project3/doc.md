--- PREPARATION ---
 Run the following in project root:
  Install curl: `sudo apt install curl`
  `chmod +x ./*.sh` to make shell scripts executable 

--- LAUNCH SERVER ---
 In project root, run `./run.sh` to start server

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

--- APACHE PROXY SETUP ---
Reference: https://plainenglish.io/blog/how-to-securely-deploy-flask-with-apache-in-a-linux-server-environment
Rename the project folder to usrgrpsrv or refactor usrgrpsrv.conf as needed for correct file paths. Create a python virtual environment with the same name and activate it
In that environment install Flask. You might need to specify the absolute path for pip, the command will look something like
`/path/to/pip install flask`. Once that's done, follow the reference attached as a guide for getting apache2 set up. For the config file,
you can copy the usrgrpsrv.conf file in this folder to /etc/apache2/sites-available then enable the site with a2ensite usergrpsrv.conf.
Move this folder to /var/www/html/. The apache config will assume the project is in that directory.
