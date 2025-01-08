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
            <label class="form-label"><strong>Admin Login</strong></label> <br>
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($_POST["adminUserName"] == "admin" && $_POST["adminPassword"] == "admin123") {
                    header("Location: adminDashboard.php");
                    exit;
                } else {
                    $errorMessage = "Incorrect username or password!";
                    include_once("../script/popup_notification.php");
                    echo '<script>document.querySelector(".popup").style.display = "block";</script>';
                }
            }
            ?>
            <form method="post">
                <input type="text" name="adminUserName" placeholder="Admin User Name" class="inputText" required> <br>
                <input type="password" name="adminPassword" placeholder="Admin Password" class="inputText" required> <br>
                <input type="submit" value="Login" class="btn">
            </form>
        </div>
    </div>

</body>
</html>
