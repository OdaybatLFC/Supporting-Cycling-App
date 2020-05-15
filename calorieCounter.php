<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="cycleApp.css">
    <link rel="icon" href="cycleIcon.png"/>
    <link rel="apple-touch-icon" href="cycleIcon.png"/>
    <link rel="shortcut icon" href="cycleIcon.png" type="image/x-icon"/>

    <meta charset="UTF-8">
    <meta name="mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-touch-fullscreen" content="yes"/>
    <meta name="mobile-web-app-fullscreen" content="yes"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">

    <title>Calorie Counter</title>
</head>
<body>
<?php

$gender = isset($_POST["Gender"]) ? $_POST["Gender"] : "";
$age = isset($_POST["Age"]) ? $_POST["Age"] : "";
$height = isset($_POST["Height"]) ? $_POST["Height"] : "";
$weight = isset($_POST["Weight"]) ? $_POST["Weight"] : "";
$duration = isset($_POST["Duration"]) ? $_POST["Duration"] : "";
$mets = isset($_POST["Mets"]) ? $_POST["Mets"] : "";
$caloriesSpent = isset($_POST["caloriesSpent"]) ? $_POST["caloriesSpent"] : "";
$distance = isset($_POST["distance"]) ? $_POST["distance"] : "";
$bmr = isset($_POST["bmr"]) ? $_POST["bmr"] : "";
$result = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // add data to the database
    //connect to database
    require_once "password.php";
    $sqlHost = "devweb2019.cis.strath.ac.uk";
    $sqlUser = "cs317groupf";
    $sqlPassword = get_pass();
    $sqlDatabase = "cs317groupf";

    $sqlConnection = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);

    if ($sqlConnection->connect_error) {
        die("Failed to connect to the database " . $sqlConnection->connect_error);
    }

    $cycleDate = date("d-m");

    if (!isset($_COOKIE["currentUser"])) {
        echo "cookie not set";
    } else {
        $currentUser = $_COOKIE["currentUser"];

        $sql = "INSERT INTO `cyclingCalories` (`username`, `calories`, `distance`, `cycleDate`) VALUES ('$currentUser', '$caloriesSpent', '$distance', '$cycleDate');";

        if ($sqlConnection->query($sql) === TRUE) {
            if ($duration !== 1) {
                $result = "<p>Your Basal Metabolic rate is $bmr (kcal/day) and you've burnt $caloriesSpent (kcal) from $duration minutes of cycling. You've travelled $distance (km)</p>";
            } else {
                $result = "<p>Your Basal Metabolic rate is $bmr (kcal/day) and you've burnt $caloriesSpent (kcal) from $duration minute of cycling. You've travelled $distance (km)</p>";
            }

        } else {
            echo '<label>Issue with insert data</label>';
            return;
        }
    }
}

?>

<header><a href="welcome.php"><img src="homeIcon.png" id="homeNav"></a>
    <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>Calorie Counter
</header>
<main>
    <div id="sidebar">
        <img src="closebutton.png" id="closeButton" onclick="moveSidebar();"/>
        <ul id="currentSettings">
            <li><a id="csLink" class="selected" href="calorieCounter.php">Calorie Counter</a></li>
            <li><a id="gdLink" href="graphData.php">Calorie Data</a></li>
            <li><a id="tfLink" href="teamForming.php">Team forming</a></li>
            <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
            <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
            <li><a id="bsLink" href="balanceSkills.html">Balance Skills</a></li>
            <li><a id="pfLink" href="profile.php">Profile</a></li>
            <li><a id="gsLink" href="logout.php">Log out</a></li>
        </ul>
    </div>
    <script src="main.js"></script>
    <script src="calorieCounter.js"></script>
</main>
<div id="caloriesBox">
    <form name="calorieForm" id="calorieForm" method="post" action="calorieCounter.php"
          onsubmit="calculate(); return formValidation()">
        <h3 id="calculateBMR">Calculate Calories:</h3>
        <p id="selectGender">Please select your gender</p>
        <input type="radio" id="Male" name="Gender" value="Male"/><label id="MaleLabel">Male</label>
        <input type="radio" id="Female" name="Gender" value="Female"/><label id="FemaleLabel">Female</label><br><br>

        <label id="ageLabel">Age (Years): </label><input type="number" onchange="formValidation()" min="0" max="150"
                                                         id="Age" name="Age" value="<?php echo $age; ?>"><br>
        <label id="heightLabel">Height (cm): </label><input type="number" onchange="formValidation()" min="0" max="230"
                                                            id="Height" name="Height"
                                                            value="<?php echo $height; ?>"><br>
        <label id="weightLabel">Weight (kg): </label><input type="number" onchange="formValidation()" min="0" max="600"
                                                            id="Weight" name="Weight"
                                                            value="<?php echo $weight; ?>"><br><br>

        <label id="metsLabel">Cycling pace (rough estimate):</label>
        <select id="Mets" name="Mets">
            <option value="3.5" selected>Extremely slow - (5.5mph)</option>
            <option value="5.8">Very slow - (9.4mph)</option>
            <option value="6.8">Slow - (10-12mph)</option>
            <option value="8.0">Moderate - (12-14mph)</option>
            <option value="10.0">Fast - (14-16mph)</option>
            <option value="12.0">Very Fast - (16-18mph)</option>
            <option value="15.8">Extremely Fast - (20-22mph)</option>
        </select>
        <br>
        <label id="durationLabel">Duration (minutes): </label><input type="number" onchange="formValidation()" min="0"
                                                                     max="1440" id="Duration" name="Duration"
                                                                     value="<?php echo $duration; ?>"><br>

        <p><input type="submit" value="Calculate" id="calculateCalories"></p>
        <input type="hidden" id="caloriesSpent" name="caloriesSpent"/>
        <input type="hidden" id="distance" name="distance"/>
        <input type="hidden" id="bmr" name="bmr"/>

    </form>
<p id="results"><?php echo $result; ?></p>
</div>
<script src="main.js"></script>
<script>
    showMenu();
</script>
</body>
</html>