import grp
import pwd
import os
from flask import Flask, request, jsonify, render_template, redirect, url_for
#subprocess to run linux shell commands from in python, and shlex to parse commands into subprocess format

"""
Given the proper username and password in an HTML form, this script will
return a list of the system's users and groups
"""

# create a flask instance, retrieving resources from the flask ('__name__') module
app = Flask(__name__)
global session_valid
global session
global goal
session = None
session_valid = False

# Do not bother showing a favicon for the page

@app.route('/favicon.ico')
def favicon():
    return '', 204

@app.route('/api', methods=['GET','POST'])
def handle_login():
    correct_username = 'test'
    correct_password = 'abcABC123'

    if(request.method == 'POST'):
        entered_username = request.form.get('username')
        entered_password = request.form.get('password')
        if(entered_username == 'test' and entered_password == 'abcABC123'):
            global session_valid
            session_valid = True
            return redirect(url_for(goal))

        else:
            return render_template('login.html')

    else: # If method is GET, that means the form hasn't been given yet.
        return render_template('login.html')


@app.route('/api/users', methods=['GET']) # one decorator per function
def users():
    global goal
    goal = 'users'
    if(session_valid):
        user_list = [user.pw_name for user in pwd.getpwall() if '/home' in user.pw_dir]
        content = "\n".join(user_list)
        return render_template('users.html', content=content)
    else:
        return redirect('/api')

@app.route('/api/groups', methods=['GET'])
def groups():
    global goal
    goal = 'groups'
    if(session_valid):
        group_list = []
        for group_entry in grp.getgrall():
            group_list.append(group_entry.gr_name)
        return render_template('groups.html', content=str("\n".join(group_list)))
    else:
        return redirect('/api')

if __name__ == '__main__':
    print(get_users())
    app.run(debug=True, host='127.0.0.1')
