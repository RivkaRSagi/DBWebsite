<!--php code for session management and connecting to database-->
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
    <!--chart.js library is imported here, and the page is connected to index.css for styling-->
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
    <!--display welcome message for the logged in user-->
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
                    <!--php while loop to pull and display library stock to the web page-->
                    <?php  
                        $name = $_SESSION['libraryname'];
                        $sql = "SELECT Title, L.ISBN, CopyID, BorrowStatus
                         FROM librarybooks AS L JOIN textbook AS T ON L.ISBN=T.ISBN WHERE LibraryName = '$name'";
                        $retreival = $conn->query($sql);
                        if ($retreival->num_rows > 0) {
                            while($row = $retreival->fetch_assoc()){
                                echo "<tr><td>".$row['Title']."</td>
                                <td>".$row['ISBN']."</td>
                                <td>".$row['CopyID']."</td>
                                <td>".$row['BorrowStatus'];
                            }
                            $retreival->close();
                        } else {
                            echo "no results";
                        }
                    ?>
                </table>
            </div>
        </div>


        
        <?php 
               // encodes the sql data to json and then adds the keys and values to a javascript array for graphing the statistics 
               $json =  BorrowDemand($conn);
        ?>
            
            <script>var Json = <?php echo $json; ?>;
            //javascript code converts json variable to js variable for the statistics pulled from database

             let books = Array.from(Object.keys(Json)); //separate json variable into two arrays representing x and y axes
             let borrows = Array.from(Object.values(Json));
             console.log(books); //check that array variables are assigned correctly
             console.log(borrows);

             function intCast(element){ // cast array variables to integers
                element = Number(element);
             }
             borrows.forEach(intCast);
             console.log(borrows);
             console.log(typeof borrows);//check that the casting worked for the arrays
             </script>
        

        <div class="majorDiv">
            <h3>Statistics</h3>
            <div class="minorDiv"> <!-- using chart.js for the statistics -->
                
            <!--the following section is written mostly in chart.js, creating the bar graph for the library page-->
            <canvas id="mylibraryChart" style="width:100%;max-width:800px;text-align:center"></canvas>
            
            <script>
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

        <!--Google Search API search container and button that is linked to the search.js file -->
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
