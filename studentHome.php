
<?php
    session_start();
    include 'db.php';
        
    $studentNum = $_SESSION['StudentID'];
    $sql = "SELECT StudentName FROM Student WHERE StudentID =  $studentNum";
    $statement = $conn->prepare($sql);
    $statement->execute();       
    $studentName = $statement->get_result();       
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
                <a href="login.html">Logout</a>
            </div>
            <div id="menuButton">
                <a href="">My Libraries</a>
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