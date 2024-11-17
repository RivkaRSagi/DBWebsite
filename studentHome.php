
<?php
    include 'db.php';
    session_start();
    
    $studentID = $_SESSION['StudentID'];
    $sql = "SELECT StudentName FROM Student WHERE StudentID = $studentID";
    $retreival = $conn->query($sql);
    // $statement->bind_param("s", $studentID);
    $row = $retreival->fetch_assoc();
    $studentName = $row["StudentName"];

    $retreival->close();
    $conn->close();

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if($_POST['Logout']){
            $SESSION = array();
            header("Location: login.html");
            exit;
        }
    }

?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Student Home</title>
    <link rel="stylesheet" href="index.css">

    
</head>
<body>
    <div class="menuBar">
        <div class="menuButtons">
            <div id="menuButton">
                <a href="studentHome.php">Home Page</a>
            </div>
            <div id="menuButton">
                <a href="">My Libraries</a>
            </div>
            <div id="menuButton">
                <form action="studentHome.php" method="post">
                    <input type="submit" name="Logout" value="Logout"/>
                </form>
            </div>
            
        </div>

    </div>



    <div class="bodyDiv">
        <p style="font-size:30px;">Welcome <?php echo $studentName ?> </p>
        <p style="font-size:30px;">this is the home page for students</p>
        <p>get student's university information from database:</p>

    </div>


</body>
</html>