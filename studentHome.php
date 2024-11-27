<?php //php code for session management and connecting to database
    include 'db.php';
    session_start();
     
    $studentID = $_SESSION['StudentID'];
    $sql = "SELECT StudentName FROM Student WHERE StudentID = $studentID";
    $retreival = $conn->query($sql);

    $row = $retreival->fetch_assoc();
    $studentName = $row["StudentName"];

    if($_SERVER['REQUEST_METHOD']==='POST'){
        if($_POST['Logout']){
            $_SESSION = array();
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
        <!--display welcome message to the logged in user-->
        <h1 id="welcome">Welcome <?php echo $studentName ?> </h1>
        <div class="majorDiv">
            <!--pull the student's university information-->
            <h3>University Information</h3>
            <div class="indent">
                <p>Student Name: <?php echo $studentName ?></p>
                <p>University Name: <?php echo $_SESSION['University'] ?></p>
                <p>Student ID: <?php echo $_SESSION['StudentID'] ?></p>
            </div>
        </div>
        <div class="majorDiv">
            <!--list the library memberships that the student has-->
        <h3>My Library Memberships</h3>
            <div class="minorDiv">
                <table>
                    <tr>
                        <th>Library Name</th>
                        <th>Card ID</th>
                    </tr>
                    <?php  
                        $university = $_SESSION['University'];
                        $sql = "SELECT LibraryName, CardID
                         FROM librarymember  WHERE StudentID = $studentID AND University = '$university'";
                        
                        $retreival = $conn->query($sql);
                        while($row = $retreival->fetch_assoc()){
                            echo "<tr><td>".$row['LibraryName']."</td>
                            <td>".$row['CardID'];
                        }
                       
                        $retreival->close();
                        $conn->close();
                    ?>
                </table>
            </div>
        </div>
    </div>
</body>
</html>