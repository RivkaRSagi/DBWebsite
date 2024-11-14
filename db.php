
<?php
//configure db
$host = "localhost";
$db = "finalproject";
$user = "person"; //global permissions given to this user for this project, can be changed in phpmyadmin
$pass = "pass";

// create connection
$conn = new mysqli($host, $user, $pass, $db);

// check connection
if($conn->connect_error){
    // die("Connection failed: " . $conn->connect_error);
    echo "connection failed";
}

?>
