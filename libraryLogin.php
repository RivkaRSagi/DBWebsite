<!--this is the login page for library admin users-->
<?php
include 'db.php';
session_start();

//check login credentials, if valid save them to the session variables and redirect to library home page

if($_SERVER['REQUEST_METHOD']==='POST'){
    $library = $_POST['libraryname'];
    $branch = $_POST['branch'];

    //check if exists in db
    $sql = "SELECT * FROM library WHERE LibraryName = ? AND BranchName = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("ss", $library, $branch);
    $statement->execute();       
    $result = $statement->get_result();

    if($result->num_rows === 1){
        $_SESSION['libraryname'] = $library;
        $_SESSION['branch'] = $branch;
        header("Location: libraryHome.php");
        exit;
    }else{
        $error_message = "Invalid Library Name or Branch";
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
                <h1>LOG IN</h1>
                <form action="" method="post">
                    <div class="libraryname">
                        <label>Library Name</label>
                        <br>
                        <input type="text" id="libraryname" name="libraryname" placeholder="Enter Library Name" required/>
                    </div>
                    <div class="branch">
                        <label>Branch</label>
                        <br>
                        <input type="text" id="branch" name="branch" placeholder="Enter Branch" required/>
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