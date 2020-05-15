
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="cycleApp.css">
    <link rel="icon" href="cycleIcon.png"/>
    <link rel="apple-touch-icon" href="cycleIcon.png"/>
    <link rel="shortcut icon" href="cycleIcon.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="messaging.css">


    <meta charset="UTF-8">
    <meta name="mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-touch-fullscreen" content="yes" />
    <meta name="mobile-web-app-fullscreen" content="yes" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <title>Team Forming</title>
</head>
<body>
<header><a href="welcome.php"><img src="homeIcon.png" id="homeNav"></a>
    <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>
    <a href="teamForming.php"><img src="thing.png" id="backButton"></a>
    Team Forming</header>

<main>
    <div id="sidebar">
        <img src="closebutton.png" id="closeButton" onclick="moveSidebar();"/>
        <ul id="currentSettings">
            <li><a id="csLink" href="calorieCounter.php">Calorie Counter</a></li>
            <li><a id="tfLink" class="selected" href="teamForming.html">Team forming</a></li>
            <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
            <li><a id="pfLink" href="profile.php">Profile</a></li>
            <li><a id="gsLink" href="logout.php">Log out</a></li>
        </ul>
    </div>
    <script src="main.js"></script>
    <script>
        showMenu();
    </script>
    <div id="chatDiv"></div>
    <div id="sendDiv">
        <form id="chatForm">
            <input type="text" placeholder="Write a message..." id="message"><br>
            <script>document.getElementById("message").style.background="lightblue";</script>
            <input type="submit" id="postButton" value="Post">
        </form>
    </div>
</main>
    <?php

    if(!isset($_COOKIE["currentUser"])) {
        echo "cookie not set";
        $cuser = "";
    } else {
        $cuser = $_COOKIE["currentUser"];
    }

    $groupID = $_GET["groupID"];
    $permission = False;

    require_once "password.php";
    $sqlHost = "devweb2019.cis.strath.ac.uk";
    $sqlUser = "cs317groupf";
    $sqlPassword = get_pass();
    $sqlDatabase = "cs317groupf";

    $conn = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
    $sql = "SELECT Username FROM `groupsTable` WHERE GroupID = '$groupID'";
    $result = $conn->query($sql);
    while ($row = $result->fetch_assoc()){
        if ($row["Username"] == $cuser){
            $permission = True;
        }
    }
    if ($permission == True){
        echo "<script src=\"teamView.js\"></script>";
        echo "<script src=\"teamModel.js\"></script>";
        echo "<script src=\"teamController.js\"></script>";
    } else{
        echo "<p>You don't have permission to view this chat</p>";
    }

    ?>
</body>
</html>
