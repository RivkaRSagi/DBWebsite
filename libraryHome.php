<?php
    include 'db.php';
    session_start();
    
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
    <title>Library Home</title>
    <link rel="stylesheet" href="index.css">
    
</head>
<body>
    <div class="menuBar">
        <div class="menuButtons">
            <div id="menuButton">
                <a href="libraryHome.html">Home Page</a>
            </div>
            <div id="menuButton">
                <form action="libraryHome.php" method="post">
                    <label for="Logout"></label>
                    <input type="submit" name="Logout" id="Logout" value="Logout"/>
                </form>
            </div>

            
        </div>

    </div>

    <div class="bodyDiv">
        <p style="font-size:30px;">Welcome <?php echo $_SESSION['libraryname'] .", ". $_SESSION['branch']." location"?> </p>

        <p>this is the home page for library locations</p>
    </div>

</body>
</html>