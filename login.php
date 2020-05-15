<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="cycleApp.css">
    <link rel="icon" href="cycleIcon.png"/>
    <link rel="apple-touch-icon" href="cycleIcon.png"/>
    <link rel="shortcut icon" href="cycleIcon.png" type="image/x-icon"/>

    <meta charset="UTF-8">
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="mobile-web-app-fullscreen" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <title>Getting Started</title>

</head>
<body>

<header><a href="index.html"><img src="homeIcon.png" id="homeNav"></a>
    <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>Getting Started</header>
<main>
    <div id="sidebar">
        <img src="closebutton.png" id="closeButton" onclick="moveSidebar();"/>
        <ul id="currentSettings">
            <li><a id="gsLink" class="selected" href="login.php">Getting Started</a></li>
            <li><a id="csLink" href="calorieCounter.html">Calorie Counter</a></li>
            <li><a id="tfLink" href="teamForming.html">Team forming</a></li>
            <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
            <li><a id="bsLink" href="balanceSkills.html">Balance Skills</a></li>
        </ul>
    </div>
</main>

<div class="gettingStarted-page">
    <div class="form">
        <?php
        //connect to database
        require_once "password.php";
        $sqlHost = "devweb2019.cis.strath.ac.uk";
        $sqlUser = "cs317groupf";
        $sqlPassword = get_pass();
        $sqlDatabase = "cs317groupf";

        $sqlConnection = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);

        //setup variables
        $name = isset($_POST["name"]) ? $sqlConnection->real_escape_string($_POST["name"]): "";
        $pass = isset($_POST["pass"]) ? $sqlConnection->real_escape_string($_POST["pass"]): "";

        function process($name, $pass, $sqlConnection)
        {
            if ($sqlConnection->connect_error) {
                die("Failed to connect to the database " . $sqlConnection->connect_error);
            }

//            check if form is valid

            if (isset($_POST['log'])) {
                if (empty($name)) {
                    echo "<label id='msg'>Please enter a name!</label>";
                    return;
                }
                if (empty($pass)) {
                    echo "<label id='msg'>Please enter a pass!</label>";
                    return;
                }

                $sql = "SELECT password FROM `cyclingAccount` WHERE username = '$name'";
                $sqlResult = $sqlConnection->query($sql);

                if (!$sqlResult) {
                    die("Failed sql query: " . $sqlConnection->error);
                } else {
                    $row = $sqlResult->fetch_assoc();
                    if ($row == null) {
                        echo "<label id='msg'>Username not found!</label>";
                        return;
                    } else {
                        $sqlPassword = $row["password"];
                    }
                }

                // decrypt database password
                if (password_verify($pass, $sqlPassword)) {
                    echo "Log in successful!";
                    // set cookie to last one day
                    setcookie("currentUser", $name, time() + (86400), "/");
                } else {
                    echo "<label id='msg'>Wrong password!</label>";
                    return;
                }
                header('Location: welcome.php');
                exit;
            }
        }
        process($name, $pass, $sqlConnection);
        ?>
        <form id="register-form" action="register.php" method="post">
            <input type="text" placeholder="username" name="name"/>
            <input type="password" placeholder="password" name="pass"/>
            <input type="text" placeholder="email" name="email"/>
            <button name="log">Register</button>
            <p class="message">Already registered? <a href="#">Log in</a></p>
        </form>
        <form id="login-form" action="login.php" method="post">
            <input type="text" placeholder="username" name="name"  value = "<?php echo $name ?>"/>
            <input type="password" placeholder="password" name="pass" value= "<?php echo $pass ?>"/>
            <button name="log">Log in</button>
            <p class="message">Not registered? <a href="#">Register</a></p>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
<script>$('.message a').click(function () {
        $('form').animate({height: "toggle", opacity: "toggle"}, "slow");
    });</script>
<script src="main.js"></script>

</body>
</html>