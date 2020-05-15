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
    <div id="chatFormDiv">
        <form id="chatForm">
            <h1 id="groupHeader">Group Name</h1>
            <input type="text" id="groupName">
            <h2 id="usersHeader">Username to add to the team</h2>
            <input type="text" id="user">
            <input type="button" id="addUserButton" value="ADD" onclick="addToList(); addUser();">
        </form>
        <ul id="userList">
            <?php if(isset($_COOKIE["currentUser"])){
                echo "<li>".$_COOKIE["currentUser"]."</li>";
            }?>
        </ul>
        <input type="button" id="submitButton" value="Submit" onclick="submit()">

    </div>
    <script>
        function addToList(){
            var listTag = document.createElement("LI");
            var user = document.getElementById("user");
            listTag.innerHTML = user.value;
            document.getElementById("userList").appendChild(listTag);
        }
    </script>
    <script src="groupCreation.js"></script>
</main>
</body>
</html>
