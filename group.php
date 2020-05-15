<?php
if (isset($_GET["id"])){
    $groupID = $_GET["id"];
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
    $sql  = "SELECT username  FROM `groupsTable` WHERE GroupID = '$groupID' AND username = '$user'";

    if($conn === false)
    {
        user_error("Unable to connect to database.");
        return false;
    }

    if ($conn->connect_error) {
        die("Failed to connect to the database " . $conn->connect_error);
    }
    $result = $conn->query($sql);

    if($result === false)
    {
        user_error("Query failed: ".$conn->error."<br />\n$sql");
        return false;
    }

    if ($result->num_rows > 0){
        $lock = true;
    } else{
        $lock = false;
    }


    $conn = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
    $sql  = "SELECT username  FROM `groupsTable` WHERE GroupID = '$groupID'";

    if($conn === false)
    {
        user_error("Unable to connect to database.");
        return false;
    }

    if ($conn->connect_error) {
        die("Failed to connect to the database " . $conn->connect_error);
    }
    $result = $conn->query($sql);

    if($result === false)
    {
        user_error("Query failed: ".$conn->error."<br />\n$sql");
        return false;
    }

    if ($result->num_rows > 0 And $lock == true){
        echo "<table>\n";
        echo "<tr>\n";
        echo "<th>Name</th>";
        echo"</tr>\n";

        while ($row = $result->fetch_assoc()){
            echo"<tr>\n";
            echo"<td>".$row["username"]."</td>\n";
            echo"</tr>\n";
        }
    }



    $conn->close();

}else{
    $groupID = "";
    echo "<p>Not working</p>";
}