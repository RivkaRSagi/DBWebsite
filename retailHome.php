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
                <a href="retailHome.php">Sales</a>
            </div>

            <div id="menuButton">
                <a href="retailStats.php">Stock and Stats</a>
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
        <h1 id="welcome">Welcome <?php echo $_SESSION['storename'] .", <br>". $_SESSION['storeaddress']." location"?> </h1>

        <div class="majorDiv">
            <p>Item Sales</p>
            <div class="minorDiv">
            <table>
                    <tr>
                        <th>Item Name</th>
                        <th>Quantity</th>
                        <th>SaleID</th>
                    </tr>
                    <tr>
                        <td>fetch from db here</td>
                        <td></td>
                        <td></td>
                    </tr>
                </table>

            </div>
        </div>

    </div>

</body>
</html>