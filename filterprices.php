<?php
include 'db.php';
session_start();
$studentID = $_SESSION['StudentID'];

$query = isset($_GET['query']) ? $_GET['query'] : '';
$filterOption = isset($_GET['filter']) ? $_GET['filter'] : 'default';

$sqlRetail = "SELECT DISTINCT 
        c.CourseName,
        c.CourseID,
        t.Title AS 'TextbookName',
        t.ISBN,
        rs.UnitPrice AS 'Price',
        'Retail' AS Type,
        rs.StoreName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN RetailStock rs ON rs.ISBN = t.ISBN
    WHERE sc.StudentID = '$studentID' 
    AND rs.UnitPrice IS NOT NULL
";
$sqlBookstoreNew = "
    SELECT DISTINCT 
        c.CourseName,
        c.CourseID,
        t.Title AS 'TextbookName',
        t.ISBN,
        sbn.UnitPrice AS 'Price',
        'Bookstore New' AS Type,
        sbn.SchoolName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN SchoolBooksNew sbn ON sbn.ISBN = t.ISBN AND sbn.SchoolName = c.SchoolName
    WHERE sc.StudentID = '$studentID' 
    AND sbn.UnitPrice IS NOT NULL
";
$sqlBookstoreUsed = "
    SELECT DISTINCT 
        c.CourseName,
        c.CourseID,
        t.Title AS 'TextbookName',
        t.ISBN,
        sbu.UnitPrice AS 'Price',
        'Bookstore Used' AS Type,
        sbu.SchoolName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN SchoolBooksUsed sbu ON sbu.ISBN = t.ISBN AND sbu.SchoolName = c.SchoolName
    WHERE sc.StudentID = '$studentID' 
    AND sbu.UnitPrice IS NOT NULL
";
$sqlLibraryBooks = "
    SELECT DISTINCT 
        c.CourseName,
        c.CourseID,
        t.Title AS 'TextbookName',
        t.ISBN,
        lb.BorrowStatus AS 'Price',
        'Library' AS Type,
        lb.LibraryName AS Location
    FROM StudentCourses sc
    JOIN Courses c ON sc.CourseID = c.CourseID AND sc.SchoolName = c.SchoolName
    JOIN CourseTextbook ct ON c.CourseID = ct.CourseID AND c.SchoolName = ct.SchoolName
    JOIN Textbook t ON ct.ISBN = t.ISBN
    LEFT JOIN LibraryBooks lb ON lb.ISBN = t.ISBN
    WHERE sc.StudentID = '$studentID' 
    AND lb.BorrowStatus IS NOT NULL
";
switch ($filterOption) {
    case 'under100':
        $sqlRetail .= " AND rs.UnitPrice < 100";
        $sqlBookstoreNew .= " AND sbn.UnitPrice < 100";
        $sqlBookstoreUsed .= " AND sbu.UnitPrice < 100";
        break;
    case 'lowtohigh':
        break;
    case 'buying':
        $sqlRetail .= " AND rs.ISBN IS NOT NULL";
        $sqlBookstoreNew .= " AND sbn.ISBN IS NOT NULL";
        $sqlBookstoreUsed .= " AND sbu.ISBN IS NOT NULL";
        $sqlLibraryBooks .= " AND lb.ISBN IS NULL";
        break;
    case 'renting':
        $sqlLibraryBooks .= " AND lb.ISBN IS NOT NULL";
        $sqlRetail .= " AND rs.ISBN IS NULL";
        $sqlBookstoreNew .= " AND sbn.ISBN IS NULL";
        $sqlBookstoreUsed .= " AND sbu.ISBN IS NULL";
        break;
    case 'retail':
        $sqlRetail .= " AND rs.ISBN IS NOT NULL";
        $sqlBookstoreNew .= " AND sbn.ISBN IS NULL";
        $sqlBookstoreUsed .= " AND sbu.ISBN IS NULL";
        $sqlLibraryBooks .= " AND lb.ISBN IS NULL";
        break;
    case 'library':
        $sqlLibraryBooks .= " AND lb.ISBN IS NOT NULL";
        $sqlRetail .= " AND rs.ISBN IS NULL";
        $sqlBookstoreNew .= " AND sbn.ISBN IS NULL";
        $sqlBookstoreUsed .= " AND sbu.ISBN IS NULL";
        break;
    case 'schoolbookstore':
        $sqlBookstoreNew .= " AND sbn.ISBN IS NOT NULL";
        $sqlBookstoreUsed .= " AND sbu.ISBN IS NOT NULL";
        $sqlLibraryBooks .= " AND lb.ISBN IS NULL";
        $sqlRetail .= " AND rs.ISBN IS NULL";
        break;
    case 'all':
        break;
    default:
        break;
}

$resultRetail = $conn->query($sqlRetail);
$resultBookstoreNew = $conn->query($sqlBookstoreNew);
$resultBookstoreUsed = $conn->query($sqlBookstoreUsed);
$resultLibraryBooks = $conn->query($sqlLibraryBooks);

$results = [];

if ($resultRetail->num_rows > 0) {
    while ($row = $resultRetail->fetch_assoc()) {
        $results[] = $row;
    }
}

if ($resultBookstoreNew->num_rows > 0) {
    while ($row = $resultBookstoreNew->fetch_assoc()) {
        $results[] = $row;
    }
}

if ($resultBookstoreUsed->num_rows > 0) {
    while ($row = $resultBookstoreUsed->fetch_assoc()) {
        $results[] = $row;
    }
}

if ($resultLibraryBooks->num_rows > 0) {
    while ($row = $resultLibraryBooks->fetch_assoc()) {
        $results[] = $row;
    }
}

if ($filterOption == 'lowtohigh') {
    usort($results, function($a, $b) {
        $priceA = ($a['Type'] == 'Library') ? $a['Price'] : $a['Price'];
        $priceB = ($b['Type'] == 'Library') ? $b['Price'] : $b['Price'];
        return $priceA - $priceB;
    });
}

if (count($results) > 0) {
    echo "<table border='1'>
            <tr>
                <th>Course Name</th>
                <th>Course ID</th>
                <th>Textbook Name</th>
                <th>ISBN</th>
                <th>Price</th>
                <th>Type</th>
                <th>Location</th>
            </tr>";

    foreach ($results as $row) {
        $price = ($row['Type'] == 'Library') ? "Borrow Status: " . $row['Price'] : "$" . number_format($row['Price'], 2);

        echo "<tr>
                <td>" . htmlspecialchars($row['CourseName']) . "</td>
                <td>" . htmlspecialchars($row['CourseID']) . "</td>
                <td>" . htmlspecialchars($row['TextbookName']) . "</td>
                <td>" . htmlspecialchars($row['ISBN']) . "</td>
                <td>" . $price . "</td>
                <td>" . htmlspecialchars($row['Type']) . "</td>
                <td>" . htmlspecialchars($row['Location']) . "</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "<p>No results found.</p>";
}

$conn->close();
?>