<?php
include 'databaseConnection.php';
include 'exportData.php';

// views
// 1. todo: reform and allow parameters somehow
function AllOptions($ISBN) {
    $query = sprintf("SELECT * FROM AllOptions WHERE ISBN = %u", $ISBN);
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "UsedCopyID: ".$row['UsedCopyID'].
        "usedUnitPrice: ".$row['UsedUnitPrice'].
        "Availability Status: ".$row['AvailabilityStatus'].
        "UsedSchoolName: ".$row['UsedSchoolName'].
        "NewUnitPrice: ".$row['NewUnitPrice'].
        "Quantity: ".$row['Quantity'].
        "NewSchoolName: ".$row['NewSchoolName'].
        "LibCopyID: ".$row['LibCopyID'].
        "BorrowStatus: ".$row['BorrowStatus'].
        "LibraryName: ".$row['LibraryName']."<br>";
      }
    } else {
      echo "0 results";
    }
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
function BorrowDemand($conn) {
  // put data in asociative php array and export to json
  $query = "SELECT * FROM BorrowDemand";
  $result = $conn->query($query);
  $data = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //echo $row[];
        $data[$row['ISBN']] = $row['Count'];
    }
    $json = exportToJSON($data);
    return $json;
  } else {
    echo "no results"; // error here instead
  }
}

// misc

?>