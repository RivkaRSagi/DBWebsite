<?php
    include 'db.php';
    include 'queries.php';
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
    <script src ="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
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
                        //$conn->close();
                    ?>
                </table>
            </div>
        </div>

        <?php echo AllOptions($conn, 7); ?>

        <div class="majorDiv">
            <h3>Statistics</h3>
            <div class="minorDiv"> <!-- using chart.js for the statistics -->
                
                   
            <canvas id="mylibraryChart" style="width:100%;max-width:800px;text-align:center"></canvas>
            <?php echo BorrowDemand($conn); ?>
            <script> //this is just using static data, still need to set up with json
            
            const xValues = [50,60,70,80,90,100,110,120,130,140,150];
            const yValues = [7,8,8,9,9,9,10,11,14,14,15];
            const barColors = ["red", "green","blue","orange","brown"];

            const chart = new Chart("mylibraryChart", {
            type: "line",
            data: {
                labels: xValues,
                datasets: [{
                    fill: false,
                    lineTension: 0,
                    backgroundColor: "green",
                    borderColor: "green",
                    data: yValues
                }]
            },
            options: {
                legend: {display: true},
                scales: {
                    yAxes: [{ticks: {min: 0, max: 20}}]
                },
                title: {
                display: true,
                text: "textbook statistics"
                }
            }
            });
            </script> 
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
    </div>
</body>
</html>