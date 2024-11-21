<?php
    include 'db.php';
    session_start();
    
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
    <title>Library Home</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="menuBar">
        <div class="menuButtons">
            <div id="menuButton">
                <form action="libraryHome.php" method="post">
                    <label for="Logout"></label>
                    <input type="submit" name="Logout" id="Logout" value="Logout"/>
                </form>
            </div>
        </div>
    </div>

    <div class="bodyDiv">
        <h1 id="welcome">Welcome <?php echo $_SESSION['libraryname'] .", <br>". $_SESSION['branch']." location"?> </h1>
        <div class="majorDiv">
            <h3>Textbooks</h3>
            <div class="minorDiv">
                <table>
                    <tr>
                        <th>Textbook Name</th>
                        <th>ISBN</th>
                        <th>CopyID</th>
                        <th>Status</th>
                    </tr>
                    <?php  
                        // $storeName = $_SESSION['storename'];
                        $sql = "SELECT Title, re.ISBN, UnitPrice, Quantity
                         FROM retailstock AS re JOIN textbook AS te ON re.ISBN=te.ISBN WHERE StoreName = 'indigo'";
                        $retreival = $conn->query($sql);
                        while($row = $retreival->fetch_assoc()){
                            echo "<tr><td>".$row['Title']."</td>
                            <td>".$row['ISBN']."</td>
                            <td>".$row['UnitPrice']."</td>
                            <td>".$row['Quantity'];
                        }
                        $retreival->close();
                        $conn->close();
                    ?>
                    <tr>
                        <td>fetch from db here</td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="majorDiv">
            <h3>Statistics</h3>
            <div class="minorDiv"> 
            </div>
        </div>
    </div>
</body>
</html>