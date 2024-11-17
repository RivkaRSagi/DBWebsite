<?php
include 'db.php';
session_start();

if($_SERVER['REQUEST_METHOD']==='POST'){
    $library = $_POST['libraryname'];
    $branch = $_POST['branch'];

    //check if exists in db
    $sql = "SELECT * FROM library WHERE LibraryName = ? AND BranchName = ?";
    $statement = $conn->prepare($sql);
    $statement->bind_param("ss", $library, $branch);
    $statement->execute();       
    $result = $statement->get_result();

    if($result->num_rows ===1 ){
        $_SESSION['libraryname'] = $library;
        $_SESSION['branch'] = $branch;
        header("Location: libraryHome.php");
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
                        <div class="libraryname">
                            <label>Library Name</label>
                            <input type="text" id="libraryname" name="libraryname" placeholder="Enter Library Name" required/>
                        </div>
                        <div class="branch">
                            <label>Branch</label>
                            <input type="text" id="branch" name="branch" placeholder="Enter Branch" required/>
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