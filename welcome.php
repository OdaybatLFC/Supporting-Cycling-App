<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="cycleApp.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          crossorigin=""/>
    <link rel="icon" href="cycleIcon.png"/>
    <link rel="apple-touch-icon" href="cycleIcon.png"/>
    <link rel="shortcut icon" href="cycleIcon.png" type="image/x-icon"/>

    <meta charset="UTF-8">
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="mobile-web-app-fullscreen" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <title>Cycling App</title>

</head>
<body>
<header>
    <a href="welcome.php"><img src="homeIcon.png" id="homeNav"></a>
        <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>Home</header>

<main>
    <div id="sidebar">
        <img src="closebutton.png" id="closeButton" onclick="moveSidebar();"/>

        <ul id="currentSettings">
            <li><a id="csLink" href="calorieCounter.php" display="block">Calorie Counter</a></li>
            <li><a id="gdLink" href="graphData.php">Calorie Data</a></li>
            <li><a id="tfLink" href="teamForming.php">Team forming</a></li>
            <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
            <li><a id="bsLink" href="balanceSkills.html">Balance Skills</a></li>
            <li><a id="pfLink" href="profile.php">Profile</a></li>
            <li><a id="gsLink" href="logout.php">Log out</a></li>
        </ul>
    </div>
    <br>
    <div id="welcomeInfo">
    <h3>Welcome to our cycle app</h3>
    <?php

    if(isset($_COOKIE["currentUser"])) {
        echo "<p>Thank you for logging in <h id='username'>" . $_COOKIE['currentUser'] . "</h>.</p>";
        echo "<img src='Tick.webp' id='pic'>";
        echo "<script>document.getElementById('pic').style.margin = '0';</script>";
        echo "<h4>From here there is so much you can do: <br></h4>";
        echo "  Log your cycle today using our <a class='options' href='calorieCounter.php'>calorie counter</a>? <br>";
        echo "  Plan a <a class='options' href='routePlanner.html'>cycle route</a>? <br>";
        echo "  Update your <a class='options' href='profile.php'>cycle profile</a>? <br>";
        echo "  Message your friends using <a class='options' href='teamForming.php'>team forming</a>? <br>";
        echo "  Practice your <a class='options' href='balanceSkills.html'>balancing skills</a>? <br>";
    } else {
        echo "Looks like you haven't logged in <br>";
        echo "Please do so at <a href='login.php' /a>";
    }
    ?>
    <br>
    </div>

    <script src="main.js"></script>
    <script>
        showMenu();
    </script>
</main>
</body>
</html>
