<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Home</title>
    <link rel="stylesheet" href="index.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="menuBar">
        <div class="menuButtons">
            <div id="menuButton">
                <a href="studentHome.php">My Information</a>
            </div>
            <div id="menuButton">
                <a href="studentTextbooks.php">Textbooks</a>
            </div>
            <div id="menuButton">
                <form action="studentHome.php" method="post">
                    <input type="submit" name="Logout" value="Logout"/>
                </form>
            </div>
        </div>
    </div>
    <div class="bodyDiv">
        <div class="majorDiv">
            <h3>Textbooks</h3>
            <div class="minorDiv">
                <div class="searchtextbook">
                    <input type="text" id="query" placeholder="Enter Course Name or Course ID">
                    <button id="searchBtn">Search</button>
                </div>
                <div class="filterDiv">
                    <select id="filterDropdown">
                        <option value="default">Default</option>
                        <option value="all">All Textbook Prices</option>
                        <option value="under100">Prices under $100</option>
                        <option value="lowtohigh">Price: Low to High</option>
                        <option value="buying">Buying Options Only</option>
                        <option value="renting">Renting Options Only</option>
                        <option value="retail">Retail Stores Only</option>
                        <option value="schoolbookstore">School Bookstore Only</option>
                        <option value="library">Library Options Only</option>
                    </select>
                </div>
                <div class="tableResults" id="tableResults">
                    <table>
                        <tr>
                        <th>Course Name</th>
                        <th>Course ID</th>
                        <th>Textbook Name</th>
                        <th>ISBN</th>
                        </tr>
                     <?php
                        include 'db.php';
                        session_start();
                        $studentID = $_SESSION['StudentID'];
        
                        $sql = "SELECT 
                            c.CourseName, 
                            c.CourseID, 
                            t.Title AS TextbookName, 
                            ct.ISBN
                            FROM StudentCourses sc
                            JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
                            JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
                            JOIN Textbook t ON ct.ISBN = t.ISBN
                            WHERE sc.StudentID = '$studentID'
                        ";
                        $result = $conn->query($sql);

                        if ($result->num_rows > 0) {
                            while($row = $result->fetch_assoc()) {
                                echo "<tr>
                                    <td>" . $row['CourseName'] . "</td>
                                    <td>" . $row['CourseID'] . "</td>
                                    <td>" . $row['TextbookName'] . "</td>
                                    <td>" . $row['ISBN'] . "</td>
                                </tr>";
                            }
                        } 
                        else {
                            echo "<tr><td colspan='4'>No courses or textbooks found for this student.</td></tr>";
                        }
                        $result->close();
                        $conn->close();
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $("#searchBtn").on("click", function(){
            var query = $("#query").val();
            if (query.length >= 0){
                $.ajax({
                    url: "searchprices.php",
                    method: "GET",
                    data: { query: query },
                    success: function(response){
                        $("#tableResults table").html(response);
                    }
                });
                
            } else {
                $.ajax({
                    url: "searchprices.php",
                    method: "GET",
                    success: function(response){
                        $("#tableResults table").html(response);
                    }
                });
            }
        });
         $('#filterDropdown').on('change', function() {
            var query = $('#query').val(); 
            var filter = $(this).val();    
         $.ajax({
            url: 'filterprices.php',
            type: 'GET',  
            data: { query: query, filter: filter },  
            success: function(data) {
            $('#tableResults').html(data);
        },
            error: function(xhr, status, error) {
            console.error("AJAX request failed: " + error);
        }
         });
        });
    </script>
</body>
</html>