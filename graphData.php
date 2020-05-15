<!DOCTYPE html>
<html>
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

    <title>Calorie Data</title>

</head>

<header><a href="welcome.php"><img src="homeIcon.png" id="homeNav"></a>
    <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>Calorie Data</header>
<main>
    <div id="sidebar">
        <img src="closebutton.png" id="closeButton" onclick="moveSidebar();"/>

        <ul id="currentSettings">
            <li><a id="csLink" href="calorieCounter.php">Calorie Counter</a></li>
            <li><a id="gdLink" class="selected" href="graphData.php">Calorie Data</a></li>
            <li><a id="tfLink" href="teamForming.php">Team forming</a></li>
            <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
            <li><a id="bsLink" href="balanceSkills.html">Balance Skills</a></li>
            <li><a id="pfLink" href="profile.php">Profile</a></li>
            <li><a id="gsLink" href="logout.php">Log out</a></li>
        </ul>
    </div>
    <script src="main.js"></script>
    <script>showMenu();</script>
    <script src="calorieCounter.js"></script>
</main>
    <?php
    //connect to database
    require_once "password.php";
    $sqlHost = "devweb2019.cis.strath.ac.uk";
    $sqlUser = "cs317groupf";
    $sqlPassword = get_pass();
    $sqlDatabase = "cs317groupf";

    $sqlConnection = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);

    if ($sqlConnection->connect_error) {
        die("Error with sql connection: " . $sqlConnection->connect_error);
    }

    $currentUser = "";

    if(!isset($_COOKIE["currentUser"])) {
        echo "username not set";
    } else {
        $currentUser = $_COOKIE["currentUser"];
    }

    $sql = "SELECT calories, distance, cycleDate FROM `cyclingCalories` WHERE username = '$currentUser'";
    $sqlResult = $sqlConnection->query($sql);


    $calories = array();
    $distance = array();
    $cycleDate = array();


    if ($sqlResult->num_rows > 0) {
        while ($row = $sqlResult->fetch_assoc()) {
            $c = $row["calories"];
            $d = $row["distance"];
            $cd = $row["cycleDate"];

            array_push($calories, $c);
            array_push($distance, $d);
            array_push($cycleDate, $cd);
        }
    }

    // display newest 10 entries
    $calories = array_slice($calories, -10, 10);
    $distance = array_slice($distance, -10, 10);
    $cycleDate = array_slice($cycleDate, -10, 10);


    json_encode($calories);
    json_encode($distance);
    json_encode($cycleDate);

    ?>

    <body>

    <div id="Graphs">

        <h4 id="calorieTitle">No data has been found, get your results from our calorie calculator to see your results </h4>

        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.bundle.js" </script>

        <script></script>

        <canvas id="calorieBarChart" width="320" height="200"></canvas>
        <script>

            // getting sql data
            var calories = <?php echo json_encode($calories) ?>;
            var distance = <?php echo json_encode($distance) ?>;
            var cycleDate = <?php echo json_encode($cycleDate) ?>;

            if(calories.length !== 0 && distance.length !== 0 && cycleDate.length !== 0) {

                document.getElementById("calorieTitle").innerHTML = "Calories burnt per cycle";

                var ctx = document.getElementById('calorieBarChart').getContext('2d');
                var calorieBarChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: cycleDate,
                        datasets: [{
                            label: 'Calories Burnt',
                            data: calories,
                            backgroundColor: [
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)'
                            ],
                            borderColor: [
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)',
                                'rgba(255,0,0,1)'
                            ],

                            borderWidth: 1
                        }]
                    },

                    options: {
                        legend: false,
                        responsive: true,
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Date of cycle'
                                }
                            }],
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Calories Burnt (kcal)'
                                },

                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        </script>


        <h4 id="distanceTitle"></h4>
        <canvas id="distanceLineGraph" width="320" height="200"></canvas>
        <script>
            // getting sql data
            var calories = <?php echo json_encode($calories) ?>;
            var distance = <?php echo json_encode($distance) ?>;
            var cycleDate = <?php echo json_encode($cycleDate) ?>;

            if(calories.length !== 0 && distance.length !== 0 && cycleDate.length !== 0) {
                document.getElementById("distanceTitle").innerHTML = "Distance travelled per cycle";

                var ctx = document.getElementById('distanceLineGraph').getContext('2d');
                var distanceLineGraph = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: cycleDate,
                        datasets: [{
                            label: 'Distance Travelled',
                            data: distance,
                            fill: false,
                            backgroundColor: [
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)'
                            ],
                            borderColor: [
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)',
                                'rgba(0,32,255,1)'
                            ],

                            borderWidth: 1
                        }]
                    },

                    options: {
                        legend: false,
                        responsive: true,
                        scales: {
                            xAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Date of cycle'
                                }
                            }],
                            yAxes: [{
                                scaleLabel: {
                                    display: true,
                                    labelString: 'Distance Travelled (km)'
                                },

                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        </script>

    </div>
   </body>
</html>