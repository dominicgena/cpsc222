<?php
session_start();

function check_auth() {
    if (isset($_SESSION['LOGGEDIN']) && $_SESSION['LOGGEDIN'] == 1) {
        return true;
    }
    show_login();
    return false;
}

function login() {
    $entered_username = sanitize($_POST['username'], 'username');
    $hashed_password = hash('sha256', sanitize($_POST['password'], 'password'));
    if($entered_username == 'bigmibbles' && $hashed_password == 'ee8bc6e495ba2413a369033967e304850c63c9f8e2d91e4d1b81f502eff27d9d') {
        $_SESSION['SPECIALUSER'] = true;
    }
    
    if (!is_valid($entered_username, $hashed_password)) {
        $_SESSION['incorrect'] = true;
        return 0;
    } else {
        $_SESSION['USER'] = $entered_username;
        $_SESSION['incorrect'] = false;
        return 1;
    }
}

function get_logins() {
    $logins = [];
    $file = fopen('auth.db','r');
    if($file) {
        while($line = fgets($file)){
            $line = trim($line);
            if(empty($line)) continue;
            $parts = preg_split("/\s+/", $line, 2);

            if (count($parts) == 2) {
                [$username, $password] = $parts;
                $logins[$username] = $password;
            }
        }
        fclose($file);
    }
    return $logins;
}

function is_valid($username, $password) {
    $logins = get_logins();
    $valid = false;
    foreach ($logins as $un => $pw) {
        if (($username == $un) && ($password == $pw)) {
            $valid = true;
            break;
        }
    }
    return $valid;
}

function show_login() {
    echo "
    <div id=\"login-form-container\">
        <form id=\"login-form\" method=\"POST\">
            <div class=\"input-containers\" id=\"username-container\">
                <label for=\"un-in\"><pre>Username </pre></label>
                <input name=\"username\" id=\"un-in\" type=\"text\">
            </div>
            <div class=\"input-containers\" id=\"password-container\">
                <label for=\"pw-in\"><pre>Password </pre></label>
                <input name=\"password\" id=\"pw-in\" type=\"password\">
            </div>
            <div class=\"input-containers\" id=\"submit\">
                <input type=\"submit\" value=\"login\">
            </div>
        </form>
    </div>
    ";
    if (isset($_SESSION['incorrect']) && $_SESSION['incorrect']) {
        echo "<h3>Incorrect login. Try again</h3>";
    }
}

function sanitize($string, $type) {
    $input = htmlspecialchars($string);
    if($type == 'username') return preg_replace("/[^a-z0-9]/i", "", $input);
    return preg_replace("/[^a-zA-Z0-9!#$%&*_\-]/", "", $input);
}

function show_dashboard() {
    $username = $_SESSION['USER'];
    echo "
    <h2>Welcome, $username! (<a href=\"./final_logout.php\">Log Out</a>)</h1>
    <p>Dashboard:</p>
    <ul>
        <li><a href=\"./final.php?page=1\">User List</a></li>
        <li><a href=\"./final.php?page=2\">Group List</a></li>
        <li><a href=\"./final.php?page=3\">Syslog</a></li>
    ";
    if($_SESSION['SPECIALUSER']) {
        echo "<li><a href=\"./final.php?page=dont-convert-this-to-ascii-01101001001000000110100001101111011100000110010100100000011110010110111101110101001000000111011101100101011100100110010101101110001001110111010000100000011001010111100001110000011001010110001101110100011010010110111001100111001000000110000100100000011001100111010101101110011011100111100100100000011011010110010101110011011100110110000101100111011001010010000001101000011001010111001001100101\">DO NOT CLICK</a>";
    }
    echo "</ul>";
}

function parse_data_from_file($filename) {
    $data = [];
    $file = fopen($filename, 'r');
    if($file) {
        while ($line = fgets($file)) {
            $line = trim($line);
            if(empty($line)) continue;// skip empty lines
            $items = explode(':', $line);
            $data[] = $items;
        }
        fclose($file);
    }
    return $data;
}

function user_list() {
    if (!isset($_SESSION['LOGGEDIN']) || $_SESSION['LOGGEDIN'] != 1) { return; }// should be impossible, but just in case
    $username = $_SESSION['USER'];
    echo "<h2>Welcome, $username! (<a href=\"./final_logout.php\">Log Out)</h2>";
    echo "<a href=\"final.php\">< Back to Dashboard</a><br><br>";
    echo "<h1>User List</h1>";
    echo "<table>
    <tr>
        <th>Username</th>
        <th>Password</th>
        <th style=\"width: 50px;\">UID</th>
        <th style=\"width: 50px;\">GID</th>
        <th>Display Name</th>
        <th>Home Directory</th>
        <th>Default Shell</th>
    </tr>";

    $users = parse_data_from_file('/etc/passwd');
    foreach ($users as $items) {
        if (count($items) === 7) {
            echo "<tr>";
            foreach ($items as $item) {
                echo "<td>" . htmlspecialchars($item) . "</td>";
            }
            echo "</tr>";
        }
    }
    echo "</table>";
}

function group_list() {
    if (!isset($_SESSION['LOGGEDIN']) || $_SESSION['LOGGEDIN'] != 1) { return; }
    $username = $_SESSION['USER'];
    echo "<h2>Welcome, $username! (<a href=\"./final_logout.php\">Log Out)</h2>";
    echo "<a href=\"final.php\">< Back to Dashboard</a><br><br>";
    echo "<h1>Group List</h1>";
    echo "<table>
    <tr>
        <th>Group Name</th>
        <th>Password</th>
        <th style=\"width: 50px;\">GID</th>
        <th>Members</th>
    </tr>";

    $groups = parse_data_from_file('/etc/group');
    foreach ($groups as $group) {
        if(count($group) >= 4) {
            echo "<tr>";
            foreach ($group as $item) {
                echo "<td>" . htmlspecialchars($item) . "</td>";
            } echo "</tr>";
        }
    } echo "</table>";
}

function format_syslog($page = 1) {
    if (!isset($_SESSION['LOGGEDIN']) || $_SESSION['LOGGEDIN'] != 1) return;
    // pagination
    $lines_per_page = 50;
    $start_line = ($page - 1) * $lines_per_page;
    $end_line = $start_line + $lines_per_page;
    $username = $_SESSION['USER'];
    echo "<h2>Welcome, $username! (<a href=\"./final_logout.php\">Log Out)</h2>";
    echo "<a href=\"final.php\">< Back to Dashboard</a><br><br>";
    echo "<h1>Syslog (Page $page)</h1>";

    $prev = $page -1;
    $next = $page + 1;
    echo "<table>
    <tr>
        <th style=\"width: 50px; \">Date</th>
        <th style=\"width: 50px; \">Hostname</th>
        <th style=\"width: 50px; \">Application[PID]</th>
        <th style=\"width: 50px; \">Message</th>
    </tr>
    ";

    $file = fopen('/var/log/syslog', 'r');
    if($file) {
        $current_line = 0;
        while ($line = fgets($file)) {
            $line = trim($line);
            if(empty($line)) continue;
            
            if ($current_line >= $start_line && $current_line < $end_line) {
                $parts = explode(' ', $line, 4);
                if(count($parts) >= 4) {
                    $timestamp = strtotime($parts[0]);
                    $date = htmlspecialchars(date('M d H:i:s', $timestamp));
                    $hostname = htmlspecialchars($parts[1]);
                    $app_pid = htmlspecialchars(rtrim($parts[2], ':'));
                    $message = htmlspecialchars($parts[3]);
                    
                    echo "
                    <tr>
                        <td>$date</td>
                        <td>$hostname</td>
                        <td>$app_pid</td>
                        <td>
                            <div class='message-container'>
                                <button class='expand-btn' onclick='toggleMessage(this)'>Expand</button>
                                <span class='message-text collapsed'>$message</span>
                            </div>
                        </td>
                    </tr>";
                }
            } $current_line++;
            if ($current_line >= $end_line) break;// no need to read the file if we passed the window
        }
        fclose($file);
    }
    else {
        echo "<tr><td colspan='4'>Error: Could not open /var/log/syslog. Check your permissions</td></tr>";
    } echo "</table>";

    // pagination navigation
    echo "<br><div style='margin-top: 10px;'>";
    if ($page > 1) echo "<a href='final.php?page=3&p=$prev'>Previous</a><br>";
    echo "<a href='final.php?page=3&p=$next'>Next</a><br></div>";
}

function handle_vip_user() {
    if($_SESSION['SPECIALUSER']) {
        echo "<h2>Welcome, $username! (<a href=\"./final_logout.php\">Log Out)</h2>";
        echo "<a href=\"final.php\">< Back to Dashboard</a><br><br>";
        echo "<h1>Dominic Gena - Personal Introduction</h1>";
        echo "<img src=\"./me.jpeg\">";
        echo "<div style=\"display: flex; width: 500px;\"><p>
        I am a lifelong guitar player and Minecraft builder. I'm really interested in full-stack web development at the moment, and I
        run a Minecraft Survival server community. I've recently finished building the website after 4 months of development <a href=\"https://sundown.social/\" target=\"_blank\">
        (click here to open in a new tab - https://sundown.social/)</a> with great pride, and have plans to use my new Typescript skills this summer to clean it up and prepare it for future plans.
        The parts I'm most proud of are the programmed dissolve slideshow transitions, the personalization configuration settings, and the logo designs.
        This project opened me to learn Docker, understand DNS, and to gain plenty of other programming skills, and I hope to face growing opportunities as
        the community grows.
        </p></div>
        ";
    } else { return; }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['LOGGEDIN'] = login();
}

?>
<!DOCTYPE HTML>
<html lang="en">
    <head>
        <title>CPSC222 Final Exam</title>
        <meta charset="utf-8"/>
        <meta name="viewport" content="width=device-width">
    </head>
    <style>
        html { background-color: #181A1B; color: white; }
        #login-form-container { width: 275px; }
        div.input-containers { display: flex; padding: 5px; align-items: center; }
        .input-containers input { height: 20px; }
        #submit { justify-self: right; margin-right: 15px; background-color: black; border: 2px solid black; border-radius: 10%; }
        div.divider { margin-top: 10px; border-top: 5px solid white; }
        table { border: 1px solid white; }
        table td, table th { border: 1px solid white; padding: 5px; }
        table th { width:  200px; }
        a, a:visited { color: cornflowerblue; text-decoration: underline; }
        .message-container { display: flex; align-items: flex-start; gap: 10px; }
        .message-text { max-width: 600px; display: inline-block; transition: all 0.3s ease; }
        .collapsed { white-space: nowrap;/* do not wrap text if collapsed */ overflow: hidden; text-overflow: ellipsis;/* ... to show text is hidden until expansion */ }
        .expanded { white-space: normal; word-break; break-all; }
        .expand-btn { padding: 2px 8px; cursor: pointer; background: #333; color: cornflowerblue; border: 1px solid cornflowerblue; font-size: 0.8em; }
    </style>
    <body>
        <h1>CPSC222 Final Exam</h1>
        <?php
        if (!isset($_SESSION['LOGGEDIN']) || $_SESSION['LOGGEDIN'] != 1) {
            check_auth();
        }
        
        else if (!isset($_GET['page'])) show_dashboard();
        else if ($_GET['page'] == '1') user_list();
        else if ($_GET['page'] == '2') group_list();
        else if ($_GET['page'] == '3') {// i implemented pagination because my browser didn't like loading the whole file
            if (isset($_GET['p'])) {
                $p = (int)$_GET['p'];
            } else { $p = 1; }
            if ($p < 1) { $p = 1; }
            format_syslog($p);
        } else if ($_GET['page'] == 'dont-convert-this-to-ascii-01101001001000000110100001101111011100000110010100100000011110010110111101110101001000000111011101100101011100100110010101101110001001110111010000100000011001010111100001110000011001010110001101110100011010010110111001100111001000000110000100100000011001100111010101101110011011100111100100100000011011010110010101110011011100110110000101100111011001010010000001101000011001010111001001100101') {
            handle_vip_user();
        }
        ?>
        <div class="divider"></div>
        <p><?php echo date('Y-m-d h:i:s A');?></p>
        <script>
            function toggleMessage(btn) {
                const span = btn.nextElementSibling;
                if (span.classList.contains('collapsed')) {
                    span.classList.remove('collapsed');
                    span.classList.add('expanded');
                    btn.innerText = 'Collapse';
                } else {
                    span.classList.remove('expanded');
                    span.classList.add('collapsed');
                    btn.innerText = 'Expand';
                }
            }
        </script>
    </body>
</html>