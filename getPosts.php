<?php

        function connectOrDie(){
            require_once "password.php";
            $sqlHost = "devweb2019.cis.strath.ac.uk";
            $sqlUser = "cs317groupf";
            $sqlPassword = get_pass();
            $sqlDatabase = "cs317groupf";

            $conn = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
            if ($conn->connect_errno){
                die("Connect failed: %s ".$conn->connect_error);
            }
            return $conn;
        }

        function getPosts($conn, $fromID){
            if (isset($_GET["groupID"])) {
                $groupID = $_GET["groupID"];
            } else {
                $groupID = 1;
            }
            $sql = "SELECT * FROM `chatTable` WHERE insertID >= '$fromID' AND GroupID = '$groupID'";
            if($result = $conn->query($sql)){
                $comments = array();

                while($row = $result->fetch_array(MYSQLI_ASSOC)){
                    $comments[] = $row;
                }
                $result->close();

                return $comments;
            }else{
                die("Query failed: %s ".$conn->error);//remove
            }
        }




            header("Content-Type: text/plain");
            header("Cache-Control: no-cache, must-revalidate");
            header("Expires: Sat, 1 Jan 2000 12:00:00 GMT");




            if (isset($_GET["startID"])){
                $firstID = ($_GET["startID"]);
            } else {
                $firstID = 0;
            }
            $conn = connectOrDie();
            $entries = getPosts($conn, $firstID);
            $entries = array_values($entries);
            for($z = 0; $z < sizeof($entries); $z++){
                echo json_encode($entries[$z])."\n";
        }
