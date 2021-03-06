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

    <title>Team Forming</title>

</head>
<body>
<script>
    function visitPage(id){
        window.location='myGroups.php?groupID='+id; //change later
    }
    function createGroup(){
        window.location="createGroup.php";
            return false;
    }
</script>
<header><a href="welcome.php"><img src="homeIcon.png" id="homeNav"></a>
    <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>Team Forming</header>
<main>
    <div id="sidebar">
        <img src="closebutton.png" id="closeButton" onclick="moveSidebar();"/>
        <ul id="currentSettings">
                    <li><a id="csLink" href="calorieCounter.php">Calorie Counter</a></li>
                    <li><a id="gdLink" href="graphData.php">Calorie Data</a></li>
                    <li><a id="tfLink" class="selected" href="teamForming.php">Team forming</a></li>
                    <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
                    <li><a id="bsLink" href="balanceSkills.html">Balance Skills</a></li>
                    <li><a id="pfLink" href="profile.php">Profile</a></li>
                    <li><a id="gsLink" href="logout.php">Log out</a></li>
        </ul>
    </div>
    <div id="teamInfo">
        <p>Create a team and start messaging team members.</p>
    </div>
    <script src="main.js"></script>
    <script>
        showMenu();
    </script>

    <button  onclick="return createGroup()" id="newTeamButton">New Team</button>
<?php
if(!isset($_COOKIE["currentUser"])) {
    echo "cookie not set";
    $user = "";
} else {
    $user = $_COOKIE["currentUser"];
}

require_once "password.php";
$sqlHost = "devweb2019.cis.strath.ac.uk";
$sqlUser = "cs317groupf";
$sqlPassword = get_pass();
$sqlDatabase = "cs317groupf";

$conn = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
$sql  = "SELECT GroupName, GroupID  FROM `groupsTable` WHERE username = '$user'";

$result = $conn->query($sql);

if ($result->num_rows > 0){

    while ($row = $result->fetch_assoc()){
        echo "<br>";
        echo "<td><button onclick=\"visitPage(".$row["GroupID"].");\" class=\"teamButton\">".$row["GroupName"]."</button></td>\n";
    }
}



$conn->close();
?>
</main>
</body>
</html>
