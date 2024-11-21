
<?php
//Configure Database
$host = "localhost";
$db = "finalproject";
$user = "root"; //global permissions given to this user for this project, can be changed in phpmyadmin
$pass = "";

//Create connection
$conn = new mysqli($host, $user, $pass, $db);

//Check Connection
if($conn->connect_error){
    // die("Connection failed: " . $conn->connect_error);
    echo "connection failed";
}
?>