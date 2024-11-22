<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Student Home</title>
    <link rel="stylesheet" href="index.css">
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
                 </div>
                <div id="tableResults">
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
</body>
</html>