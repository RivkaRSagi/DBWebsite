<?php
include 'db.php';
include 'exportData.php';

// views
// 1. todo: reform and allow parameters somehow
function AllOptions($conn, $ISBN) {
    $query = sprintf("SELECT * FROM AllOptions WHERE ISBN = %u", $ISBN);
    $result = $conn->query($query);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "UsedCopyID: ".$row['usedCopyID'].
        ", usedUnitPrice: ".$row['usedUnitPrice'].
        ", Availability Status: ".$row['AvailabilityStatus'].
        ", UsedSchoolName: ".$row['usedSchoolName'].
        ", NewUnitPrice: ".$row['newUnitPrice'].
        ", Quantity: ".$row['Quantity'].
        ", NewSchoolName: ".$row['newSchoolName'].
        ", LibCopyID: ".$row['libCopyID'].
        ", BorrowStatus: ".$row['BorrowStatus'].
        ", LibraryName: ".$row['LibraryName']."<br>";
      }
    } else {
      echo "0 results";
    }
}

 // 2. also reform to make parameters
 function StudentPrices($conn, $ISBN, $cost) {
  $query = sprintf("SELECT * FROM StudentPrices WHERE ISBN = %u AND BookStorePrice < %u AND RetailPrice < %u AND PrivateSellerPrice < %u",
   $ISBN, $cost, $cost, $cost);
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "ISBN: ".$row['ISBN'].
      ", BookStorePRice: ".$row['BookStorePrice'].
      ", RetailPRice: ".$row['RetailPrice'].
      ", PRivate Seller Price: ".$row["PrivateSellerPrice"].
      "<br>";
    }
  } else {
    echo "0 results";
  }
}

 // 3
 function TextbooksRequired($conn){
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

 // 8
 function LibraryOptions($conn, $studentID){
  $query = sprintf("SELECT * FROM LibraryOptions WHERE StudentID = %u;", $studentID);
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "StudentID: " . $row['StudentID'] .
         ", ISBN: " . $row['ISBN'] .
          ", copyID: " . $row['copyid'] .
           ", BorrowStatus: " . $row['borrowstatus'] .
           ", LibraryName". $row["libraryname"]. "<br>";
      }
    } else {
      echo "0 results";
    }
}

function PurchaseOptions($conn) {
  $query = sprintf("SELECT * FROM PurchaseOptions");
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo ", title: ".$row['title'].
      ", sourceOfSale: ".$row['sourceOfSale'].
      ", Price: ".$row['Price'].
      "<br>";
    }
  } else {
    echo "0 results";
  }
}

function AvailableRentals($conn) {
  $query = sprintf("SELECT * FROM AvailableRentals");
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo "ISBN: ".$row['ISBN'].
      "title: ".$row['title'].
      ", unitPrice: ".$row['unitPrice'].
      ", AvailabilityStatus: ".$row['AvailabilityStatus'].
      "<br>";
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

function RetailDemand($conn){
  // put data in asociative php array and export to json
  $query = "SELECT * FROM RetailDemand";
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

// add textbook
function AddItem($conn, $ISBN, $price, $quantity, $storeName) {
  $sqlCreate = "INSERT INTO RetailStock (ISBN, UnitPrice, Quantity, StoreName)
        VALUES ($ISBN, $price, $quantity, '$storeName')";

        $insertion = $conn->query($sqlCreate);
        if($insertion === TRUE){
            echo '<script>alert("New record created successfully")</script>';
        }else{
            //echo "ERROR: ".$sqlCreate."<br>". $conn->error;
            echo '<script>alert("Error")</script>';
        }
        //$insertion->close();
}

?>