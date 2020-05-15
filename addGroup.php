
<?php
ob_start();
if(!isset($_COOKIE["currentUser"])) {
    echo "cookie not set";
    $cuser = "";
} else {
    $cuser = $_COOKIE["currentUser"];
}

require_once "password.php";
$sqlHost = "devweb2019.cis.strath.ac.uk";
$sqlUser = "cs317groupf";
$sqlPassword = get_pass();
$sqlDatabase = "cs317groupf";

$users = array_values($_GET["users"]);
$groupName = $_GET["groupName"];

$conn = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
$sql = "SELECT MAX(GroupID) FROM `groupsTable`";
$result = $conn->query($sql);
foreach (array_values($result->fetch_assoc()) as &$max)
    $new = $max + 1;
$conn = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
$x = 0;
$sql  = "INSERT INTO `groupsTable` (`GroupID`, `GroupName`, `Username`, `Accepted`) VALUES ('$new', '$groupName', '$users[$x]', 0)";
for ($x = 1; $x < sizeof($users); $x++){
    $newsql = ", ('$new', '$groupName', '$users[$x]', 0)";
    $sql= $sql.$newsql;
}
$newsql = ", ('$new', '$groupName', '$cuser', 0)";
$sql= $sql.$newsql;
if ($conn->query($sql)) {
    return $users;
} else {
    die("Query failed: %s " . $conn->error);
}
$conn->close();
header('Location: teamForming.php');
ob_end_flush();
