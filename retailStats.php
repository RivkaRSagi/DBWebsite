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
                <a href="retailHome.php">Stock</a>
            </div>
            <div id="menuButton">
                <a href="retailStats.php">Sales and Stats</a>
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
    <div class="majorDiv">
            <h3>Item Sales</h3>
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
        <div class="majorDiv">
            <h3>Statistics</h3>
            <div class="minorDiv">
            </div>
        </div>
    </div>
</body>
</html>