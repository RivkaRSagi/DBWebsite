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


        <?php 
            $json =  BorrowDemand($conn);
        ?>
            <script>var Json = <?php echo $json; ?>;

             let books = Array.from(Object.keys(Json));
             let borrows = Array.from(Object.values(Json));
             console.log(books);
             console.log(borrows);

             function intCast(element){
                element = Number(element);
             }
             borrows.forEach(intCast);
             console.log(borrows);
             console.log(typeof borrows);
             </script>
        

        <div class="majorDiv">
            <h3>Statistics</h3>
            <div class="minorDiv"> <!-- using chart.js for the statistics -->
                
                   
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
                    data: borrows
                }]
            },
            options: {
                legend: {display: false},
                scales: {
                    yAxes: [{ticks: {min: 0, max: 20}}],
                },
                title: {
                display: true,
                text: "Borrowing Statistics: Borrows per Textbook"
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