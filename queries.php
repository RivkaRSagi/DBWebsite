<?php

include 'db.php';

// views
// 1. todo: reform and allow parameters somehow
function AllOptions($ISBN) {
    $query = "SELECT * FROM ";
}

 // 2. also reform to make parameters

 // 3
 function TextbooksRequired(){
    $query = "SELECT * FROM TextbooksRequired;";
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
          echo "courseID: " . $row['courseID'] . ", schoolName: " . $row['schoolName'] . ", ISBN: " . $row['isbn'] . ", Title: " . $row['title'] . "<br>";
        }
      } else {
        echo "0 results";
      }
 }

 


// statistics

// misc

?>