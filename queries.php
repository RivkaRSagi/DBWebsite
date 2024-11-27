<?php
include 'db.php';
include 'exportData.php';

// views
// 1. Returns all textbook options, both buying and renting, new and used 
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

 // 2. select all buying options for a specific textbook and filtering by price 
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

 // 3. Returns all required textbooks for a student
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

 // 4. return all purchasing options from all retail locations joining their stores and stock 
 function BuyingOptions($conn){
  $query = "SELECT * FROM BuyingOptions;";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "StoreName: " . $row['StoreName'] .
         ", Address: " . $row['Address'] .
          ", ISBN: " . $row['ISBN'] .
           ", UnitPrice: " . $row['UnitPrice'] .
           ", Quantity: ". $row["Quantity"]. "<br>";
      }
    } else {
      echo "0 results";
    }
}

// 5. return all books from school bookstores, both new and used
function SchoolBookStoreOptions($conn){
  $query = "SELECT * FROM schoolbookstoreoptions;";
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "ISBN: " . $row['ISBN'] .
         ", SchoolName: " . $row['SchoolName'] .
          ", InStock  : " . $row['InStock'] .
           ", UnitPrice: " . $row['UnitPrice'] . "<br>";
      }
    } else {
      echo "0 results";
    }
}

 // 7. finds the cheapest textbook available for each ISBN 
function CheapestTextbooks($conn) {
  $query = sprintf("SELECT * FROM CheapestTextbooks");
  $result = $conn->query($query);

  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
      echo ", ISBN: ".$row['ISBN'].
      ", MinPrice: ".$row['MinPrice'].
      "<br>";
    }
  } else {
    echo "0 results";
  }
}

 // 8. returns all library books from libraries the student is a member of
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

// 9 srudents can view all availale options for buying including schoolbookstore, retail and private sellers 
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

//10 all available options for renting including books and the schoolbookstore 
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

function BorrowDemand($conn) { // Returns the number of times each book in the library was borrowed 
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
    echo "no results"; 
  }

}

function RetailDemand($conn){ // Returns the number of times each book was purchased from a specific retail location 
  // put data in asociative php array and export to json
  $query = "SELECT * FROM RetailDemand";
  $result = $conn->query($query);
  $data = array();

  if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
      //echo $row[];
        $data[$row['isbn']] = $row['Count'];
    }
    $json = exportToJSON($data);
    return $json;
  } else {
    echo "no results"; 
  }
}

// misc

// add textbook to the retail stock of a store
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
