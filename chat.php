<?php
        function connectOrDie()
        {
            require_once "password.php";
            $sqlHost = "devweb2019.cis.strath.ac.uk";
            $sqlUser = "cs317groupf";
            $sqlPassword = get_pass();
            $sqlDatabase = "cs317groupf";

            $conn = new mysqli($sqlHost, $sqlUser, $sqlPassword, $sqlDatabase);
            if ($conn->connect_errno) {
                die("Connect failed: %s " . $conn->connect_error);
            }
            return $conn;
        }

        function addPost($conn, $post, $postID, $groupID)
        {
            if (isset($_COOKIE["currentUser"])) {
                $user = $_COOKIE["currentUser"];
                $sql = "INSERT INTO `chatTable` (`Username`, `Message`, `UID`, `GroupID`) VALUES ('$user', '$post', '$postID', '$groupID')";
                if ($conn->query($sql)) {
                    return $postID;
                } else {
                    die("Query failed: %s " . $conn->error);
                }
            } else{
                die("User not logged in or does not have cookies enabled");
            }

        }


            $conn = connectOrDie();
            $groupID = $conn->real_escape_string(urldecode($_POST["groupID"]));
            $post = $conn->real_escape_string(urldecode($_POST["msg"]));
            $postID = $conn->real_escape_string(urldecode($_POST["uid"]));
            $id = addPost($conn, $post, $postID, $groupID);
            echo "$id";



