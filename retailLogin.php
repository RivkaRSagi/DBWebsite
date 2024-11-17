<?php
    include 'db.php';
    session_start();

    if($_SERVER['REQUEST_METHOD']==='POST'){
        $storeName = $_POST['storename'];
        $address = $_POST['storeaddress'];

        //check if exists in db
        $sql = "SELECT * FROM retail WHERE StoreName = ? AND Address = ?";
        $statement = $conn->prepare($sql);
        $statement->bind_param("ss", $storeName, $address);
        $statement->execute();
        $result = $statement->get_result();

        if($result->num_rows === 1){
            $_SESSION['storename'] = $storeName;
            $_SESSION['storeaddress'] =  $address;
            header("Location: retailHome.php");
            exit;
        }else{
            echo "Invalid input";
        }

        $statement->close();
        $conn->close();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
    </head>
    <body>
        <a href="login.html">go back</a>
        <div class="container">
            <div class="row"></div>
                <h2>LOG IN</h2>
                <form action="" method="post">
                    <div class="storename">
                        <label>Store Name</label>
                        <input type="text" id="storename" name="storename" placeholder="Enter Store Name" required/>
                    </div>
                    <div class="storeaddress">
                        <label>Store Address</label>
                        <input type="text" id="storeaddress" name="storeaddress" placeholder="Enter Store Address" required/>
                    </div>
                   
                    <div class="submit">
                        <button type="submit">
                            Log in
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>