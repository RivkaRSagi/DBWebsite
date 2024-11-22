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
        $error_message = "Invalid Store Name or Store Address!";
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
        <link rel="stylesheet" href="login.css">
    </head>
    <body>
        <a href="login.html" id="goBack">go back</a>
        <br>
        <div class="container">
            <div class="row"></div>
                <h2>LOG IN</h2>
                <form action="" method="post">
                    <div class="storename">
                        <label>Store Name</label>
                        <br>
                        <input type="text" id="storename" name="storename" placeholder="Enter Store Name" required/>
                    </div>
                    <div class="storeaddress">
                        <label>Store Address</label>
                        <br>
                        <input type="text" id="storeaddress" name="storeaddress" placeholder="Enter Store Address" required/>
                    </div>
                    <div class="submit">
                        <button type="submit">
                            Log in
                        </button>
                    </div>
                </form>
                <!-- Show the error message if it exists -->
                <?php if (!empty($error_message)):?>
                    <p class="errorMessageBox" style="color: red;">
                        <?php echo htmlspecialchars($error_message); ?>
                    </p>
                <?php endif; ?>
            </div>
        </div>
    </body>
</html>