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
    <title>Retail Home</title>
    <link rel="stylesheet" href="index.css">
    
</head>
<body>
    <div class="menuBar">
        <div class="menuButtons">
            <div id="menuButton">
                <a href="retailHome.html">Home Page</a>
            </div>

            <div id="menuButton">
                <a href="retailStats.html">Statistics</a>
            </div>
            <div id="menuButton">
                <form action="retailHome.php" method="post">
                    <label for="Logout"></label>
                    <input type="submit" name="Logout" id="Logout" value="Logout"/>
                </form>
            </div>
        </div>

    </div>
    <div class="bodyDiv">
        <p style="font-size:30px;">Welcome <?php echo $_SESSION['storename'] .", ". $_SESSION['storeaddress']." location"?> </p>
        <p style="font-size:30px;">this is the home page for retail stores</p>

    </div>

</body>
</html>