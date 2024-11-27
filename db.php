<?php //db.php, purpose is to connect to the database
//Configure Database according to how it is saved in mySql on your computer
$host = "localhost";
$db = "sys2";
$user = "root"; //global permissions given to this user for this project, can be changed in phpmyadmin
$pass = "";

//error handle
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