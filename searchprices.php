<?php
include 'db.php';

$query = isset($_GET['query']) ? $_GET['query'] : '';
$query = mysqli_real_escape_string($conn, $query);
$sql = "SELECT DISTINCT 
        c.CourseName, 
        c.CourseID, 
        t.Title AS TextbookName, 
        ct.ISBN,
        sbn.UnitPrice AS UnitPrice, 
        'School Bookstore (New)' AS Type, 
        sbn.SchoolName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN SchoolBooksNew sbn ON sbn.ISBN = ct.ISBN AND sbn.SchoolName = c.SchoolName
    WHERE (c.CourseName LIKE '%$query%' OR c.CourseID LIKE '%$query%') AND sbn.UnitPrice IS NOT NULL
    UNION
    SELECT DISTINCT 
        c.CourseName, 
        c.CourseID, 
        t.Title AS TextbookName, 
        ct.ISBN,
        sbu.UnitPrice AS UnitPrice, 
        'School Bookstore (Used)' AS Type, 
        sbu.SchoolName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN SchoolBooksUsed sbu ON sbu.ISBN = ct.ISBN AND sbu.SchoolName = c.SchoolName
    WHERE (c.CourseName LIKE '%$query%' OR c.CourseID LIKE '%$query%') AND sbu.UnitPrice IS NOT NULL
    UNION
    SELECT DISTINCT 
        c.CourseName, 
        c.CourseID, 
        t.Title AS TextbookName, 
        ct.ISBN,
        rs.UnitPrice AS UnitPrice, 
        'Retail' AS Type, 
        rs.StoreName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN RetailStock rs ON rs.ISBN = ct.ISBN
    LEFT JOIN Retail r ON rs.StoreName = r.StoreName
    WHERE (c.CourseName LIKE '%$query%' OR c.CourseID LIKE '%$query%') AND rs.UnitPrice IS NOT NULL
    UNION
    SELECT DISTINCT 
        c.CourseName, 
        c.CourseID, 
        t.Title AS TextbookName, 
        ct.ISBN,
        lb.BorrowStatus AS UnitPrice, 
        'Library' AS Type, 
        lb.LibraryName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN LibraryBooks lb ON lb.ISBN = ct.ISBN
    LEFT JOIN Library l ON lb.LibraryName = l.LibraryName
    WHERE (c.CourseName LIKE '%$query%' OR c.CourseID LIKE '%$query%') AND lb.BorrowStatus IS NOT NULL
";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Course Name</th><th>Course ID</th><th>Textbook Name</th><th>ISBN</th><th>Unit Price</th><th>Type</th><th>Location</th></tr>";
    while ($row = $result->fetch_assoc()) {
        if ($row['Type'] == 'Library') {
            $unitPrice = "Borrow Status: " . $row['UnitPrice'];
        } else {
            $unitPrice = $row['UnitPrice'];
        }

        echo "<tr>
                <td>" . $row['CourseName'] . "</td>
                <td>" . $row['CourseID'] . "</td>
                <td>" . $row['TextbookName'] . "</td>
                <td>" . $row['ISBN'] . "</td>
                <td>" . $unitPrice . "</td>
                <td>" . $row['Type'] . "</td>
                <td>" . $row['Location'] . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found for the specified course.</p>";
}
$conn->close();
?>