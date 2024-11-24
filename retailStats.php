<?php
include 'db.php';
include 'exportData.php';
session_start();

if($_SERVER['REQUEST_METHOD']==='POST'){
    if($_POST['Logout']){
        $SESSION = array();
        header("Location: login.html");
        exit;
    }
}

if (isset($_POST['exportsales'])) {    
    $query = "SELECT * FROM ItemSales";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $data = [];
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    //get columns
    $columns = [];
    $fieldInfo = $result->fetch_fields();
    foreach ($fieldInfo as $field) {
        $columns[] = $field->name;
    }
    
    exportToCSV($columns, $data, "Sales Log");
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

    <!-- Export Sales Log Form -->
    <form action="retailStats.php" method="POST">
        <button type="submit" name="exportsales">Export Sales Log</button>
    </form>

    <div class="majorDiv">
        <h3>Statistics</h3>
        <div class="minorDiv">
        </div>
    </div>
    </div>
</body>
</html>