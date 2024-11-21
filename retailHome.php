<?php
include 'db.php';
session_start();

$storeName = $_SESSION['storename'];

if($_SERVER['REQUEST_METHOD']==='POST'){
    if(isset($_POST['Logout'])){
        $_SESSION = array();
        header("Location: login.html");
        exit;
    }
    else if(isset($_POST['addItem'])){ //currently not working properly
        echo "adding an item";
        $ISBN = $_POST['ISBN'];
        $price = $_POST['price'];
        $quantity = $_POST['quantity'];

        //check for valid input
        $sqlCreate = "INSERT INTO retailstock (ISBN, UnitPrice, Quantity, StoreName)
        VALUES ($ISBN, $price, $quantity, $storeName);";
        $statement = $conn->prepare($sqlCreate);
        $statement ->bind_param("sifs", $ISBN, $price,$quantity, $storeName);
        $statement->execute();
    }
    else if(isset($_POST['removeItem'])){
        echo "removing an item";
    }
    else if(isset($_POST['updateItem'])){
        echo "updating an item";
    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Retail Home</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="menuBar">
        <div class="menuButtons">
            <div id="menuButton">
                <a href="retailHome.php">Stock</a>
            </div>
            <div id="menuButton">
                <a href="retailStats.php">Sales and Stats</a>
            </div>
            <div id="menuButton">
                <form action="retailHome.php" method="post">
                    <label for="Logout"></label>
                    <input type="submit" name="Logout" id="Logout" value="Logout"/>
                </form>
            </div>
        </div>
    </div>
    <div class="bodyDiv">
        <h1 id="welcome">Welcome <?php echo $_SESSION['storename'] .", <br>". $_SESSION['storeaddress']." location"?> </h1>
        <div class="majorDiv">
            <h3>Item Stock</h3>
            <div class="minorDiv">
            <table>
                    <tr>
                        <th>Product Name</th>
                        <th>ISBN</th>
                        <th>Price</th>
                        <th>Quantity</th>
                    </tr>
                    <?php  
                        $storeName = $_SESSION['storename'];
                        $sql = "SELECT Title, re.ISBN, UnitPrice, Quantity
                         FROM retailstock AS re JOIN textbook AS te ON re.ISBN=te.ISBN WHERE StoreName = '$storeName'";
                        
                        $retreival = $conn->query($sql);
                        while($row = $retreival->fetch_assoc()){
                            echo "<tr><td>".$row['Title']."</td>
                            <td>".$row['ISBN']."</td>
                            <td>".$row['UnitPrice']."</td>
                            <td>".$row['Quantity'];
                        }
                       
                        $retreival->close();
                        $conn->close();
                    ?>
                </table>
            </div>
        </div>
        <div class="majorDiv">
            <h3>Update Stock</h3>
            <div class="minorDiv">
                <table>
                    <tr>
                        <td> 
                            Add New Item:    
                            <button class="allowInput" onclick="allowInput('add')">add</button>
                        </td>   
                    </tr>
                    <tr>
                        <td>
                            <div class="CRUDoptions" id="add">
                                <p>Enter book details:</p>
                                <form action="retailHome.php" method="post">
                                    <div class="ISBN">
                                        <label for="ISBN">ISBN:</label>
                                        <input type="text" id="ISBN" name="ISBN" placeholder="ISBN" required/>
                                    </div>
                                    <div class="price">
                                        <label for="price">Unit Price:</label>
                                        <input type="number" id="price" name="price" placeholder="0.00" min="0" step="0.01" required/>
                                    </div>
                                    <div class="quantity">
                                        <label for="quantity">Quantity:</label>
                                        <input type="number" id="quantity" name="quantity" placeholder="0"/>
                                    </div>
                                    <div class="submit">
                                        <button type="submit" value="addItem">
                                            confirm
                                        </button>
                                    </div>
                                    <div class="cancel">
                                        <button type="button" onclick="closeInput('add')">cancel</button>
                                    </div>
                                </form>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td> 
                            Remove Existing Item:    
                            <button class="allowInput" onclick="allowInput('remove')">remove</button>
                        </td> 
                    </tr> 
                    <tr>
                        <td>
                            <div class="CRUDoptions" id="remove">
                                <p>Enter book ISBN:</p>
                                <form action="retailHome.php" method="post">
                                    <div class="ISBN">
                                        <label for="ISBN">ISBN:</label>
                                        <input type="text" id="ISBN" name="ISBN" placeholder="ISBN" required/>
                                    </div>
                                    <div class="submit" value="removeItem">
                                        <button type="submit">
                                            confirm
                                        </button>
                                    </div>
                                    <div class="cancel">
                                        <button type="button" onclick="closeInput('remove')">cancel</button>
                                    </div>
                                </form>
                            </div>
                        </td>  
                    </tr>
                    <tr>
                        <td> 
                            Update Item Quantity:    
                            <button class="allowInput" onclick="allowInput('update')">update</button>
                        </td> 
                    </tr> 
                    <tr>
                        <td>
                            <div class="CRUDoptions" id="update">
                                <p>Enter item ISBN and the new quantity value:</p>
                                <form action="retailHome.php" method="post">
                                    <div class="ISBN">
                                        <label for="ISBN">ISBN:</label>
                                        <input type="text" id="ISBN" name="ISBN" placeholder="ISBN" required/>
                                    </div>
                                    <div class="quantity">
                                        <label for="quantity">New Quantity:</label>
                                        <input type="number" id="quantity" name="quantity" placeholder="0"/>
                                    </div>
                                    <div class="submit" value="updateItem">
                                        <button type="submit">
                                            confirm
                                        </button>
                                    </div>
                                    <div class="cancel">
                                        <button type="button" onclick="closeInput('update')">cancel</button>
                                    </div>
                                </form>
                            </div>
                        </td>  
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <script>
        //for opening and closing the CRUD forms
        function allowInput(inputType){
            document.getElementById(inputType).style.display = "block";
        }
        function closeInput(inputType){
            document.getElementById(inputType).style.display = "none";
        }
    </script>
</body>
</html>