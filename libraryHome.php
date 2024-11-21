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
                        $name = $_SESSION['libraryname'];
                        $sql = "SELECT Title, L.ISBN, CopyID, BorrowStatus
                         FROM librarybooks AS L JOIN textbook AS T ON L.ISBN=T.ISBN WHERE LibraryName = '$name'";
                        $retreival = $conn->query($sql);
                        while($row = $retreival->fetch_assoc()){
                            echo "<tr><td>".$row['Title']."</td>
                            <td>".$row['ISBN']."</td>
                            <td>".$row['CopyID']."</td>
                            <td>".$row['BorrowStatus'];
                        }
                        $retreival->close();
                        $conn->close();
                    ?>
                </table>
            </div>
        </div>
        <div class="majorDiv">
            <h3>Google Books Search</h3>
            <div class="search-bar">
                <input type="text" id="query" placeholder="Enter book title,author, or ISBN">
                <button onclick="searchBooks()" id="searchbutton">Search</button>
            </div>

            <div id="book-results" class="book-results"></div>
        </div>
        <script src="search.js"></script>


        <div class="majorDiv">
            <h3>Statistics</h3>
            <div class="minorDiv"> 
            </div>
        </div>
    </div>
</body>
</html>