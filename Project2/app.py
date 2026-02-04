from flask import Flask, request, jsonify, render_template, redirect, url_for

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
            session_valid = True
            return render_template(f'{goal}.html') # returns user to original location before login redirect

        else:
            return render_template('login.html')

    else: # If method is GET, that means the form hasn't been given yet.
        return render_template('login.html')


@app.route('/api/users', methods=['GET']) # one decorator per function
def users():
    global goal
    goal = 'users'
    if(session_valid):
        return 'Session valid! Hello from users!'
    else:
        return redirect('/api')

@app.route('/api/groups', methods=['GET'])
def groups():
    global goal
    goal = 'groups'
    if(session_valid):
        return 'Session valid! Hello from groups!'
    else:
        return redirect('/api')

if __name__ == '__name__':
    app.run(host='127.0.0.1')
