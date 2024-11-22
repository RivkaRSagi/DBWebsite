<?php
include 'db.php';
session_start();
 
if($_SERVER['REQUEST_METHOD']==='POST'){
    $uniname = $_POST['University'];
    $studentNum = $_POST['StudentID'];

    //check if exists in db
    $sql = "SELECT * FROM Student WHERE University = ? AND StudentID = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("ss", $uniname, $studentNum);
    $statement->execute();       
    $result = $statement->get_result();

    if($result->num_rows === 1){
        $_SESSION['University'] = $uniname;
        $_SESSION['StudentID'] = $studentNum;
        header("Location: studentHome.php");
        exit;
    }else{
        echo "Invalid input";
    }

    $statement->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <a href="login.html" id="goBack">go back</a>
        <br>
        <div class="container">
            <div class="row"></div>
                <h2>LOG IN</h2>
                <form action="studentLogin.php" method="post">
                    <div class="University">
                        <label for="University">University</label>
                        <br>
                        <input type="text" id="University" name="University" placeholder="Enter University Name" required/>
                    </div>
                    <div class="password">
                        <label for="StudentID">StudentID</label>
                        <br>
                        <input type="password" name="StudentID" id="StudentID" placeholder="Enter Student ID" required/>
                    </div>
                    <div class="submit">
                        <button type="submit">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>