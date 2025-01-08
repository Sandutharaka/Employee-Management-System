<?php
include_once("../conf/conf.php");
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve username and password from the form
    $userName = $_POST["userName"];
    $userPassword = $_POST["userPassword"];

    // Query to check if the username and password match in the database
    $query = "SELECT * FROM employee WHERE empId = '$userName' AND empPassword = '$userPassword'";
    $result = mysqli_query($conn, $query);

    // Check if any rows are returned
    if (mysqli_num_rows($result) > 0) {
        $_SESSION['user'] = $userName;
        // Username and password are correct, redirect to dashboard or perform further actions
        header("Location: userDashboard.php");
        exit();
    } else {
        // Username or password is incorrect, display an alert
        echo "<script>alert('Username or password incorrect');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="comhtml">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../style/style.css">
    <?php include_once("../style/fontIconConfig.html"); ?>
    <title>Employee Management System</title>
</head>
<body>
    <?php include_once("../script/header.php"); ?>

    <div class="container">
        <div class="logincontainer">
            <label class="form-label"><strong>User Login</strong></label> <br>
            <form method="post">
                <input type="text" name="userName" placeholder="User Name" class="inputText" required> <br>
                <input type="password" name="userPassword" placeholder="User Password" class="inputText" required> <br>
                <input type="submit" value="Login" class="btn">
            </form>
        </div>
    </div>

</body>
</html>
