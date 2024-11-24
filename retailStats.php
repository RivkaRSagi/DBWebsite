<?php
include 'db.php';
include 'exportData.php';
session_start();

if($_SERVER['REQUEST_METHOD']==='POST'){
    if($_POST['Logout']){
        $_SESSION = array();
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
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>

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
                <?php  
                        $storeName = $_SESSION['storename'];
                        $sql = "SELECT ProductName, Quantity, SaleID
                         FROM itemsales  WHERE StoreName = '$storeName'";
                        
                        $retreival = $conn->query($sql);
                        while($row = $retreival->fetch_assoc()){
                            echo "<tr><td>".$row['ProductName']."</td>
                            <td>".$row['Quantity']."</td>
                            <td>".$row['SaleID'];
                        }
                       
                        $retreival->close();
                        $conn->close();
                    ?>
            </table>
        </div>         
    </div>

    <!-- Export Sales Log Form -->
    <form action="retailStats.php" method="POST">
        <button type="submit" name="exportsales">Export Sales Log</button>
    </form>

    <?php 
            $json =  RetailDemand($conn);
        ?>
            <script>var Json = <?php echo $json; ?>;

             let books = Array.from(Object.keys(Json));
             let buys = Array.from(Object.values(Json));
             console.log(books);
             console.log(buys);

             function intCast(element){
                element = Number(element);
             }
             buys.forEach(intCast);
             console.log(buys);
             </script>

    <div class="majorDiv">
        <h3>Statistics</h3>
        <div class="minorDiv">
        <canvas id="mylibraryChart" style="width:100%;max-width:800px;text-align:center"></canvas>
            
            <script> //this is just using static data, still need to set up with json
            const barColors = ["red", "green","blue","orange","brown"];

            const chart = new Chart("mylibraryChart", {
            type: "bar",
            data: {
                labels: books,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: barColors,
                    data: buys
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: 0, max: 20}}],
                },
                title: {
                display: true,
                text: "Buying Statistics: Purchases per Textbook"
                }
            }
            });
            </script> 
        </div>
    </div>
    </div>
</body>
</html>