
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
                <a href="studentHome.php">My Information</a>
            </div>
            <div id="menuButton">
                <a href="studentTextbooks.php">Textbooks</a>
            </div>
            <div id="menuButton">
                <form action="studentHome.php" method="post">
                    <input type="submit" name="Logout" value="Logout"/>
                </form>
            </div>
            
        </div>

    </div>



    <div class="bodyDiv">
        <h1 id="welcome">Welcome <?php echo $studentName ?> </h1>
        <div class="majorDiv">
            <h3>University Information</h3>
            <div class="indent">
                <p>Student Name: </p>
                <p>University Name: </p>
                <p>Student ID: </p>
            </div>
            
        </div>

        <div class="majorDiv">
        <h3>My Library Memberships</h3>
            <div class="minorDiv">
                <table>
                    <tr>
                        <th>Library Name</th>
                        <th>Card ID</th>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

    </div>


</body>
</html>