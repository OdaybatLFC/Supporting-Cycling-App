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

    <title>Profile</title>

</head>
<body>
<header><a href="welcome.php"><img src="homeIcon.png" id="homeNav"></a>
    <img src="sidebarIcon.png" id="navButton" onclick="moveSidebar();"/>Profile
</header>
<main>
    <div id="sidebar">
        <img src="closebutton.png" id="closeButton" onclick="moveSidebar();"/>
        <ul id="currentSettings">
            <li><a id="csLink" href="calorieCounter.php">Calorie Counter</a></li>
            <li><a id="gdLink" href="graphData.php">Calorie Data</a></li>
            <li><a id="tfLink" href="teamForming.php">Team forming</a></li>
            <li><a id="rpLink" href="routePlanner.html">Route Planner</a></li>
            <li><a id="bsLink" href="balanceSkills.html">Balance Skills</a></li>
            <li><a id="pfLink" class="selected" href="profile.php">Profile</a></li>
            <li><a id="gsLink" href="logout.php">Log out</a></li>
        </ul>
    </div>
    <script src="main.js"></script>
    <script>
        showMenu();
    </script>
    <br>
    <div id="profile">
        <?php
        function safePOST($conn, $name)
        {
            if (isset($_POST[$name])) {
                return $conn->real_escape_string(strip_tags($_POST[$name]));
            } else {
                return "";
            }
        }

        $currentUser = "";
        if (!isset($_COOKIE["currentUser"])) {
            echo "Current user cookie timed out, try logging in again!";
        } else {
            $currentUser = $_COOKIE["currentUser"];
        }
        //connect to database
        require_once "password.php";
        $sqlHost = "devweb2019.cis.strath.ac.uk";
        $sqlUser = "cs317groupf";
        $sqlPassword = get_pass();
        $sqlDatabase = "cs317groupf";

        $sqlConnection = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);

        $currentProfile = isset($_GET["currentProfile"]) ? $sqlConnection->real_escape_string($_GET["currentProfile"]) : $currentUser;
        echo "<h1>$currentProfile's Profile</h1>";
        //IMAGE HERE ---------------------------------------------------------------------------------------------------------------------------------------------------

        $sql = "SELECT * FROM `profiles` WHERE username = '$currentProfile'";
        $sqlResult = $sqlConnection->query($sql);
        $row = $sqlResult->fetch_assoc();
        $num_rows = $sqlResult->num_rows;
        if ($num_rows == 0) {
            $sql = "INSERT INTO `profiles` (`username`, `favouriteRoutes`, `imgUploaded`, `fileExtension`, `bio`) VALUES ('$currentProfile', '', '0', '', '')";
            $sqlConnection->query($sql);

            $sql = "SELECT * FROM `profiles` WHERE username = '$currentProfile'";
            $sqlResult = $sqlConnection->query($sql);
            $row = $sqlResult->fetch_assoc();
        }


        $isImageUploaded = $row["imgUploaded"];
        $fileExtension = $row["fileExtension"];
        $path = "profilePictures/";
        if ($isImageUploaded == 0) {
            echo "<img src='profilePictures/defaultprofilepic.png'>";
        } elseif ($isImageUploaded == 1) {
            $src = $path . "user" . $currentProfile . $fileExtension;
            echo "<img src='$src'>";
        }

        if ($sqlConnection->connect_error) {
            die("Error with sql connection: " . $sqlConnection->connect_error);
        }
        $action = safePOST($sqlConnection, "action");
        $favREdit = safePOST($sqlConnection, "favREdit");
        $bioEdit = safePOST($sqlConnection, "bioEdit");
        if ($action == "update") {
            $sql = "UPDATE `profiles` SET `favouriteRoutes` = '$favREdit', `bio` = '$bioEdit' WHERE `profiles`.`username` = '$currentUser'";
            if ($sqlConnection->query($sql) === TRUE) {
            } else {
                die("Error on updating database" . $sqlConnection->error);
            }
        } elseif ($action == "newImage") {
            //Upload image to database
            $path = "profilePictures/";
            $file = $_FILES["profilePic"];

            $fileName = $file["name"];
            $fileTmpName = $file["tmp_name"];
            $fileType = $file["type"];

            $fileExt = explode('.', $fileName);
            //Split file name into an array eg "test.png" will be ["test","png"]
            // so we want the last bit so we use end() to get file extension
            $fileActualExt = strtolower(end($fileExt));

            $validFileTypes = array('png', 'jpeg', 'jpg');

            if (in_array($fileActualExt, $validFileTypes)) {
                $newFileName = $currentUser;

                $sql = "UPDATE `profiles` SET `imgUploaded` = '1',`fileExtension` = '$fileActualExt' WHERE `profiles`.`username` = '$currentUser'";
                if ($sqlConnection->query($sql) === TRUE) {
                } else {
                    die("Error on updating database" . $sqlConnection->error);
                }

                if (move_uploaded_file($fileTmpName, $path . "user" . $currentUser . $fileActualExt)) {
                } else {
                    echo "<p>Image uploading failed.</p>";
                }
            } else {
                echo "Invalid file type.";
            }
        }
        echo "<div id='profileSubBox'>";
        $sql = "SELECT * FROM `profiles` WHERE username = '$currentProfile'";
        $sqlResult = $sqlConnection->query($sql);

        if ($currentProfile == $currentUser) {
            ?>
            <script>
                function editProfile() {
                    document.getElementById("beforeEdit").style.display = "none";
                    document.getElementById("profileSearch").style.display = "none";
                    document.getElementById("edits").style.display = "block";
                }
            </script>
        <?php

        if (!$sqlResult) {
            die("Failed sql query: " . $sqlConnection->error);
        } else {
        $row = $sqlResult->fetch_assoc();
        //We are in our profile, but not in edit mode.
        echo "<div id=\"beforeEdit\">";
        if ($row == null) {
            echo "<h3 class='profileHeader'>Favourite Routes: </h3>";
            echo "User has not setup any favourite routes :(";
            echo "<h3 class='profileHeader'>Bio: </h3>";
            echo "User has not setup bio";
            return;
        } else {
            $favRoutes = $row["favouriteRoutes"];
            $bio = $row["bio"];
            echo "<h3 class='profileHeader'>Favourite Routes: </h3>";
            if ($favRoutes == "") {
                echo "User has not setup any favourite routes :(";
            } else {
                echo "$favRoutes";
            }
            echo "<h3 class='profileHeader'>Bio: </h3>";
            if ($bio == "") {
                echo "User has not setup bio";
            } else {
                echo "$bio";
            }
        }
        echo "<br><br><button onclick='editProfile()' id='editButton'>Edit Profile</button>";
        echo "</div>";

        //We are in edit mode of our profile.?>
            <div id="edits">
                <form id="imageForm" action="profile.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="newImage">
                    <input type="file" name="profilePic">
                    <button type="submit" name="upload"> Upload</button>
                </form>
                <form id="editForm" action="profile.php" method="post">
                    <input type="hidden" name="action" value="update">
                    <?php
                    if ($row == null) {
                        echo "You have not setup any favourite routes :(";
                        ?>
                        <h3 class='profileHeader'>Favourite Routes: </h3>
                        <input type="text" name="favREdit"
                               id="favREdit"><br>
                        <h3 class='profileHeader'>Bio: </h3>
                        <input type="text" name="bioEdit"
                               id="bioEEdit"><br>
                        <?php
                        return;
                    } else {
                        $favRoutes = $row["favouriteRoutes"];
                        $bio = $row["bio"];
                        echo "<h3 class='profileHeader'>Favourite Routes: </h3>";
                        echo "<input type=\"text\" name=\"favREdit\" value=\"$favRoutes\"><br><br>";
                        echo "<h3 class='profileHeader'>Bio: </h3>";
                        echo "<input type=\"text\" name=\"bioEdit\" value=\"$bio\"><br><br>";
                    }


                    ?>
                    <input type="submit" value="Save Changes">
                </form>
            </div>
            <script>
                document.getElementById("edits").style.display = "none";
            </script>
            <?php
        }
        } else {
            //We are in someone else's profile.
            if (!$sqlResult) {
                die("Failed sql query: " . $sqlConnection->error);
            } else {
                $row = $sqlResult->fetch_assoc();
                if ($row == null) {
                    echo "<h3 class='profileHeader'>Favourite Routes: </h3>";
                    echo "User has not setup any favourite routes :(";
                    echo "<h3 class='profileHeader'>Bio: </h3>";
                    echo "User has not setup bio";
                } else {
                    $favRoutes = $row["favouriteRoutes"];
                    $bio = $row["bio"];
                    echo "<h3 class='profileHeader'>Favourite Routes: </h3>";
                    if ($favRoutes == "") {
                        echo "User has not setup any favourite routes :(";
                    } else {
                        echo "$favRoutes";
                    }
                    echo "<h3 class='profileHeader'>Bio: </h3>";
                    if ($bio == "") {
                        echo "User has not setup bio";
                    } else {
                        echo "$bio";
                    }
                }
            }
        }
        ?>

        <div id="profileSearch">
            <form action="profile.php" method="get">
                <p id="profileSearchHeader"><strong>Profile Search:</strong><input type="text" name="currentProfile"
                                                                                   placeholder="Search for a profile">
                    <input type="submit" value="Go">
                </p>
            </form>
        </div>
    </div>
    </div>
    </div>
</main>
</body>
</html>