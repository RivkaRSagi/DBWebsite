<?php
//Configure Database
$host = "localhost";
$db = "finalproject";
$user = "root"; //global permissions given to this user for this project, can be changed in phpmyadmin
$pass = "";

//Check Connection
// if($conn->connect_error){
//     // die("Connection failed: " . $conn->connect_error);
//     echo "connection failed";
// }

try {
    //Create connection
    $conn = new mysqli($host, $user, $pass, $db);
} catch (mysqli_sql_exception $e) {
    //Error Handling
    //error_log("Database connection error: " . $e->getMessage(), 3, "errors.log");
    echo "We are currently experiencing technical difficulties.<br>Please try again later.<br>";
    echo "Database Connection Failed.";
    exit;
}
?>